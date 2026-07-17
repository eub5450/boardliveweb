<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\EntryFrame;
use App\Models\MyBeg;
use DB;

class StoreController extends Controller
{
    public function Index()
    {
        $data = EntryFrame::orderBy('id', 'desc')->get();
        $usageCounts = MyBeg::select('store_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('store_id')
            ->groupBy('store_id')
            ->pluck('total', 'store_id');

        return view('backend.setting.store', compact('data', 'usageCounts'));
    }

    public function Store(Request $request)
    {
        $validated = $this->validateStoreEffect($request);

        try {
            $data = new EntryFrame;
            $this->fillStoreEffect($data, $validated);
            $data->save();

            return Redirect()->back()->with([
                'messege' => 'Effect Created Successfully',
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $error) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'Effect create failed: '.$error->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    public function Update($id, Request $request)
    {
        $data = EntryFrame::find($id);

        if (!$data) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'Effect not found',
                'alert-type' => 'error',
            ]);
        }

        $validated = $this->validateStoreEffect($request, $data);

        try {
            $this->fillStoreEffect($data, $validated);
            $data->save();

            return Redirect()->back()->with([
                'messege' => 'Effect Update Successfully',
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $error) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'Effect update failed: '.$error->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    public function ToggleShow($id)
    {
        $data = EntryFrame::find($id);

        if (!$data) {
            return Redirect()->back()->with([
                'messege' => 'Effect not found',
                'alert-type' => 'error',
            ]);
        }

        $data->is_show = (int) $data->is_show === 1 ? 0 : 1;
        $data->save();

        return Redirect()->back()->with([
            'messege' => $data->is_show ? 'Effect is now visible in app' : 'Effect is now hidden from app store',
            'alert-type' => 'success',
        ]);
    }

    public function Destroy($id)
    {
        $data = EntryFrame::find($id);

        if (!$data) {
            return Redirect()->back()->with([
                'messege' => 'Effect not found',
                'alert-type' => 'error',
            ]);
        }

        $usageCount = MyBeg::where('store_id', $data->id)->count();
        if ($usageCount > 0) {
            $data->is_show = 0;
            $data->save();

            return Redirect()->back()->with([
                'messege' => 'Effect is used by '.$usageCount.' user inventory row(s), so it was hidden instead of deleted.',
                'alert-type' => 'warning',
            ]);
        }

        try {
            $data->delete();

            return Redirect()->back()->with([
                'messege' => 'Unused effect deleted successfully',
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $error) {
            return Redirect()->back()->with([
                'messege' => 'Effect delete failed: '.$error->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    private function validateStoreEffect(Request $request, EntryFrame $existing = null)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'time' => 'required|integer|min:1|max:3650',
            'type' => 'required|in:0,1',
            'image' => 'nullable|string|max:255',
            'effect' => 'nullable|string|max:255',
            'image_upload' => 'nullable|file|max:10240',
            'effect_upload' => 'nullable|file|max:51200',
            'is_show' => 'nullable|in:0,1',
        ]);

        $validated['image'] = trim((string) ($validated['image'] ?? ($existing ? $existing->image : '')));
        $validated['effect'] = trim((string) ($validated['effect'] ?? ($existing ? $existing->effect : '')));

        if ($request->hasFile('image_upload')) {
            $validated['image'] = $this->storeUploadedFile($request->file('image_upload'), 'admin-store/images', ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
        }

        if ($request->hasFile('effect_upload')) {
            $validated['effect'] = $this->storeUploadedFile($request->file('effect_upload'), 'admin-store/effects', ['svga', 'json']);
        }

        if ($validated['image'] === '') {
            throw ValidationException::withMessages(['image' => 'Image path or image upload is required.']);
        }

        if ($validated['effect'] === '') {
            throw ValidationException::withMessages(['effect' => 'Effect file path or effect upload is required.']);
        }

        return $validated;
    }

    private function fillStoreEffect(EntryFrame $data, array $validated)
    {
        $data->name = $validated['name'];
        $data->price = (string) $validated['amount'];
        $data->time = (string) $validated['time'];
        $data->type = (int) $validated['type'];
        $data->image = $validated['image'];
        $data->effect = $validated['effect'];
        $data->is_show = array_key_exists('is_show', $validated) ? (int) $validated['is_show'] : 1;
    }

    private function storeUploadedFile($file, $subDir, array $allowedExtensions)
    {
        if (!$file || !$file->isValid()) {
            throw ValidationException::withMessages(['upload' => 'Upload failed. Please choose a valid file.']);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $allowedExtensions, true)) {
            throw ValidationException::withMessages(['upload' => 'Invalid upload type: '.$extension]);
        }

        $safeName = preg_replace('/[^a-zA-Z0-9_-]+/', '-', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $safeName = trim($safeName, '-') ?: 'store-file';
        $fileName = gmdate('YmdHis').'-'.uniqid().'-'.$safeName.'.'.$extension;
        $relativeDir = 'store/'.$subDir;
        $targetDir = base_path($relativeDir);

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $file->move($targetDir, $fileName);

        return $relativeDir.'/'.$fileName;
    }
}
