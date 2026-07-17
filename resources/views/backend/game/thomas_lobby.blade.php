@extends('backend.layouts.main')

@section('title')
Thomas Game Lobby
@endsection

@section('content')
@php
    $adminCan = function($key, $default = false) { return \App\Models\AdminParmisiton::allowed(Auth::id(), $key, $default); };
@endphp

<style>
    .thomas-lobby-page{padding:24px;background:#f3f6fb;min-height:calc(100vh - 70px)}
    .thomas-hero{position:relative;overflow:hidden;border-radius:26px;padding:28px;background:linear-gradient(135deg,#071321,#10264a 52%,#441a66);color:#fff;box-shadow:0 20px 45px rgba(4,15,34,.18);margin-bottom:22px}
    .thomas-hero:before{content:"";position:absolute;right:-90px;top:-110px;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(0,217,255,.34),rgba(0,217,255,0) 68%)}
    .thomas-hero:after{content:"";position:absolute;left:38%;bottom:-130px;width:360px;height:260px;border-radius:50%;background:radial-gradient(circle,rgba(255,214,110,.24),rgba(255,214,110,0) 65%)}
    .thomas-hero-content{position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:18px;flex-wrap:wrap}
    .thomas-kicker{text-transform:uppercase;letter-spacing:2px;font-size:12px;color:#8eeaff;font-weight:800;margin-bottom:8px}
    .thomas-title{font-size:34px;line-height:1.08;margin:0 0 8px;font-weight:900;color:#fff}
    .thomas-copy{margin:0;color:#d8e8ff;max-width:720px}
    .thomas-actions{display:flex;gap:10px;flex-wrap:wrap}
    .thomas-btn{border:0;border-radius:999px;padding:11px 16px;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:7px;box-shadow:0 10px 24px rgba(0,0,0,.14);cursor:pointer}
    .thomas-btn-primary{background:linear-gradient(135deg,#16d5ff,#6d5dfc);color:#fff}
    .thomas-btn-dark{background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.2)}
    .thomas-btn-live{background:linear-gradient(135deg,#11c881,#06a767);color:#fff}
    .thomas-btn-off{background:linear-gradient(135deg,#ff6b6b,#d6254c);color:#fff}
    .thomas-summary{display:grid;grid-template-columns:repeat(3,minmax(150px,1fr));gap:14px;margin-bottom:20px}
    .thomas-stat{background:#fff;border:1px solid #e4eaf5;border-radius:18px;padding:18px;box-shadow:0 12px 28px rgba(22,36,66,.08)}
    .thomas-stat span{display:block;color:#68738a;font-size:12px;text-transform:uppercase;letter-spacing:1px;font-weight:800}
    .thomas-stat strong{display:block;color:#121827;font-size:30px;line-height:1.1;margin-top:8px}
    .thomas-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:18px}
    .thomas-card{background:#fff;border:1px solid #e4eaf5;border-radius:24px;overflow:hidden;box-shadow:0 14px 36px rgba(22,36,66,.1);display:flex;flex-direction:column}
    .thomas-banner{height:132px;position:relative;background:linear-gradient(135deg,#101827,#1f3b73 55%,#8422a8);display:flex;align-items:center;justify-content:center;color:#fff;text-align:center}
    .thomas-banner img{width:100%;height:100%;object-fit:cover;display:block}
    .thomas-banner-placeholder{padding:18px}
    .thomas-banner-placeholder .icon{font-size:38px;line-height:1;margin-bottom:8px}
    .thomas-card-body{padding:18px;display:flex;flex-direction:column;gap:14px;flex:1}
    .thomas-card-title{margin:0;color:#141b2d;font-size:20px;font-weight:900}
    .thomas-code{display:inline-flex;width:max-content;border-radius:999px;padding:5px 10px;background:#eef4ff;color:#315a96;font-size:12px;font-weight:800}
    .thomas-status{display:flex;align-items:center;justify-content:space-between;gap:12px;border-radius:16px;padding:12px;background:#f7f9fd;border:1px solid #edf1f7}
    .thomas-status strong{display:block;color:#111827}
    .thomas-status small{display:block;color:#6d7484}
    .thomas-pill{border-radius:999px;padding:7px 11px;font-size:12px;font-weight:900;white-space:nowrap}
    .thomas-pill-live{background:#ddfff1;color:#047a4c}
    .thomas-pill-maintenance{background:#fff0f3;color:#b3163a}
    .thomas-card-actions{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:auto}
    .thomas-card-actions form{margin:0}
    .thomas-card-actions .thomas-btn{width:100%;justify-content:center}
    .thomas-alert{border-radius:16px;padding:14px 16px;margin-bottom:18px;font-weight:700}
    .thomas-alert-success{background:#eafff5;color:#056f46;border:1px solid #b8f2d9}
    .thomas-alert-error{background:#fff0f3;color:#a81033;border:1px solid #ffd0da}
    .thomas-foot{margin-top:22px;text-align:center;color:#8a93a5;font-size:10px;font-weight:800}
    @media(max-width:720px){.thomas-lobby-page{padding:14px}.thomas-title{font-size:26px}.thomas-summary{grid-template-columns:1fr}.thomas-card-actions{grid-template-columns:1fr}}
</style>

<div class="body-content thomas-lobby-page">
    <div class="thomas-hero">
        <div class="thomas-hero-content">
            <div>
                <div class="thomas-kicker">Main Admin Control</div>
                <h1 class="thomas-title">Thomas Game Lobby</h1>
                <p class="thomas-copy">Control which Thomas game rooms are live from this admin panel. Off mode sends users to maintenance immediately.</p>
            </div>
            <div class="thomas-actions">
                <a class="thomas-btn thomas-btn-primary" href="{{ $lobbyUrl }}" target="_blank" rel="noopener">Open Player Lobby</a>
                <a class="thomas-btn thomas-btn-dark" href="{{ $adminUrl }}" target="_blank" rel="noopener">Open Thomas Admin</a>
            </div>
        </div>
    </div>

    @if(session('messege'))
        <div class="thomas-alert thomas-alert-success">{{ session('messege') }}</div>
    @endif
    @if($errorMessage)
        <div class="thomas-alert thomas-alert-error">{{ $errorMessage }}</div>
    @endif

    <div class="thomas-summary">
        <div class="thomas-stat"><span>Total Rooms</span><strong>{{ $summary['total'] ?? 0 }}</strong></div>
        <div class="thomas-stat"><span>Live Now</span><strong>{{ $summary['live'] ?? 0 }}</strong></div>
        <div class="thomas-stat"><span>Maintenance</span><strong>{{ $summary['maintenance'] ?? 0 }}</strong></div>
    </div>

    <div class="thomas-grid">
        @forelse($games as $game)
            <div class="thomas-card">
                <div class="thomas-banner">
                    @if(!empty($game['banner']))
                        <img src="{{ $game['banner'] }}" alt="{{ $game['name'] }} banner" onerror="this.style.display='none'; this.parentNode.querySelector('.thomas-banner-placeholder').style.display='block';">
                        <div class="thomas-banner-placeholder" style="display:none">
                            <div class="icon">GAME</div>
                            <strong>{{ $game['name'] }}</strong>
                        </div>
                    @else
                        <div class="thomas-banner-placeholder">
                            <div class="icon">GAME</div>
                            <strong>{{ $game['name'] }}</strong>
                        </div>
                    @endif
                </div>
                <div class="thomas-card-body">
                    <div>
                        <h3 class="thomas-card-title">{{ $game['name'] }}</h3>
                        <span class="thomas-code">{{ $game['game_code'] }}</span>
                    </div>
                    <div class="thomas-status">
                        <div>
                            <strong>{{ $game['status_label'] }}</strong>
                            <small>{{ $game['status_text'] }}</small>
                        </div>
                        <span class="thomas-pill {{ $game['is_live'] ? 'thomas-pill-live' : 'thomas-pill-maintenance' }}">{{ $game['is_live'] ? 'ON' : 'OFF' }}</span>
                    </div>
                    <div class="thomas-card-actions">
                        <form method="post" action="{{ url('admin/thomas-game-lobby/status') }}">
                            @csrf
                            <input type="hidden" name="game_code" value="{{ $game['game_code'] }}">
                            <input type="hidden" name="mode" value="live">
                            <button class="thomas-btn thomas-btn-live" type="submit" {{ $game['is_live'] ? 'disabled' : '' }}>On / Live</button>
                        </form>
                        <form method="post" action="{{ url('admin/thomas-game-lobby/status') }}">
                            @csrf
                            <input type="hidden" name="game_code" value="{{ $game['game_code'] }}">
                            <input type="hidden" name="mode" value="maintenance">
                            <button class="thomas-btn thomas-btn-off" type="submit" {{ !$game['is_live'] ? 'disabled' : '' }}>Off / Maintenance</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="thomas-alert thomas-alert-error">No Thomas game rooms found.</div>
        @endforelse
    </div>

    <div class="thomas-foot">Powerd by JAMBOai</div>
</div>
@endsection
