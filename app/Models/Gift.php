<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Agency;
class Gift extends Model
{
    protected $fillable = [
        'sander_id',
        'reciever_id',
        'name',
        'value',
        'channelName',
        'date'
    ];
    use HasFactory;
     /* =========================================
        RELATIONSHIPS
    ========================================= */

    // Sender User
    public function sender()
    {
        return $this->belongsTo(User::class, 'sander_id');
    }

    // Receiver User
    public function receiver()
    {
        return $this->belongsTo(User::class, 'reciever_id');
    }

    // Agency / Family
    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_code', 'code');
    }

    /* =========================================
        DATE FILTER SCOPE
    ========================================= */
    public function scopeBetweenDates($query, $start, $end)
    {
        $timezone = config('app.timezone', 'Europe/London');
        $startAt = Carbon::parse($start, $timezone)->startOfDay()->toDateTimeString();
        $endAt = Carbon::parse($end, $timezone)->endOfDay()->toDateTimeString();

        return $query->where('date', '>=', $startAt)
                     ->where('date', '<=', $endAt);
    }

    /* =========================================
        TOP SENDERS
    ========================================= */
    public function scopeTopSanders($query, $start, $end, $limit = 3, $skip = 0)
    {
        return $query
            ->with('sender')
            ->betweenDates($start, $end)
            ->selectRaw('sander_id, SUM(value) as total_sand')
            ->groupBy('sander_id')
            ->orderByDesc('total_sand')
            ->skip($skip)
            ->limit($limit)
            ->get()
            ->map(function ($row) {
                return [
                    'sander_id'  => $row->sander_id,
                    'total_sand'=> $row->total_sand,
                    'name'      => optional($row->sender)->name,
                    'profile'   => optional($row->sender)->profile,
                    'is_vip'    => optional($row->sender)->is_vip,
                    'frame'     => optional($row->sender)->frame,
                    'level'     => optional($row->sender)->level,
                ];
            });
    }

    /* =========================================
        TOP RECEIVERS
    ========================================= */
    public function scopeTopReceivers($query, $start, $end, $limit = 3, $skip = 0)
    {
        return $query
            ->with('receiver')
            ->betweenDates($start, $end)
            ->selectRaw('reciever_id, SUM(value) as total_sand')
            ->groupBy('reciever_id')
            ->orderByDesc('total_sand')
            ->skip($skip)
            ->limit($limit)
            ->get()
            ->map(function ($row) {
                return [
                    'reciever_id'=> $row->reciever_id,
                    'total_sand'=> $row->total_sand,
                    'name'      => optional($row->receiver)->name,
                    'profile'   => optional($row->receiver)->profile,
                    'is_vip'    => optional($row->receiver)->is_vip,
                    'frame'     => optional($row->receiver)->frame,
                    'level'     => optional($row->receiver)->level,
                ];
            });
    }

    /* =========================================
        TOP FAMILIES / AGENCIES
    ========================================= */
    public function scopeTopFamilies($query, $start, $end, $limit = 3, $skip = 0)
    {
        return $query
            ->with('agency')
            ->betweenDates($start, $end)
            ->selectRaw('agency_code, SUM(value) as total_sand')
            ->groupBy('agency_code')
            ->orderByDesc('total_sand')
            ->skip($skip)
            ->limit($limit)
            ->get()
            ->map(function ($row) {
                return [
                    'agency_code' => $row->agency_code,
                    'total_sand'  => $row->total_sand,
                    'name'        => optional($row->agency)->name,
                    'logo'        => optional($row->agency)->logo,
                ];
            });
    }
}
