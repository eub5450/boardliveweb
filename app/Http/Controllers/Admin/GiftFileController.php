<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\GiftFile;
use App\Models\BrdBackground;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Image;

class GiftFileController extends Controller
{
    private const GIFT_CATEGORIES = [
        1 => 'Regular',
        2 => 'Luxury',
        3 => 'Festival',
        4 => 'Entry',
        5 => 'Frame',
        6 => 'Event',
        7 => 'Soundless',
    ];

    public function index()
    {
        $gifts = GiftFile::orderBy('id', 'desc')->get();
        $categories = self::GIFT_CATEGORIES;

        return view('backend.gift.index', compact('gifts', 'categories'));
    }

    public function Store(Request $request)
    {
        $validated = $this->validateGift($request);

        try {
            $gift = new GiftFile();
            $this->fillGift($gift, $validated, $request);
            $gift->save();
            $this->forgetGiftCache();

            return Redirect()->back()->with([
                'messege' => 'Gift Store Successfully',
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $error) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'Gift Store Failed: '.$error->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    public function Delete($id)
    {
        $gift = GiftFile::find($id);
        if (!$gift) {
            return Redirect()->back()->with([
                'messege' => 'Gift not found',
                'alert-type' => 'error',
            ]);
        }

        $gift->delete();
        $this->forgetGiftCache();

        return Redirect()->back()->with([
            'messege' => 'Gift Removed Successfully',
            'alert-type' => 'success',
        ]);
    }

    public function Update($id, Request $request)
    {
        $gift = GiftFile::find($id);
        if (!$gift) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'Gift not found',
                'alert-type' => 'error',
            ]);
        }

        $validated = $this->validateGift($request, $gift);

        try {
            $this->fillGift($gift, $validated, $request);
            $gift->save();
            $this->forgetGiftCache();

            return Redirect()->back()->with([
                'messege' => 'Gift Update Successfully',
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $error) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'Gift Update Failed: '.$error->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    private function validateGift(Request $request, GiftFile $existing = null): array
    {
        $validated = $request->validate([
            'category' => 'required|integer|in:1,2,3,4,5,6,7',
            'name' => 'required|string|max:255',
            'value' => 'required|integer|min:0',
            'image_name' => 'nullable|string|max:255',
            'svga_name' => 'nullable|string|max:255',
            'image' => $existing ? 'nullable|file|max:10240' : 'required|file|max:10240',
            'svga' => $existing ? 'nullable|file|max:51200' : 'required|file|max:51200',
        ]);

        if ($request->hasFile('image')) {
            $this->assertUploadExtension($request->file('image'), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        }

        if ($request->hasFile('svga')) {
            $this->assertUploadExtension($request->file('svga'), ['svga']);
        }

        return $validated;
    }

    private function fillGift(GiftFile $gift, array $validated, Request $request): void
    {
        $gift->category = (int) $validated['category'];
        $gift->name = $validated['name'];
        $gift->value = (int) $validated['value'];
        $gift->amount = (int) $validated['value'];

        if ($request->hasFile('image')) {
            $imagePath = $this->storeUploadedGiftFile($request->file('image'), 'image');
            $gift->image = $imagePath;
            $gift->image_name = basename($imagePath);
        } elseif (!empty($validated['image_name'])) {
            $gift->image_name = $validated['image_name'];
        }

        if ($request->hasFile('svga')) {
            $svgaPath = $this->storeUploadedGiftFile($request->file('svga'), 'svga');
            $gift->svga = $svgaPath;
            $gift->svga_name = basename($svgaPath);
        } elseif (!empty($validated['svga_name'])) {
            $gift->svga_name = $validated['svga_name'];
        }

        if (!$gift->image || !$gift->svga || !$gift->image_name || !$gift->svga_name) {
            throw ValidationException::withMessages([
                'gift' => 'Gift image and SVGA file are required.',
            ]);
        }
    }

    private function assertUploadExtension($file, array $allowed): void
    {
        if (!$file || !$file->isValid()) {
            throw ValidationException::withMessages(['upload' => 'Upload failed. Please choose a valid file.']);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $allowed, true)) {
            throw ValidationException::withMessages(['upload' => 'Invalid upload type: '.$extension]);
        }
    }

    private function storeUploadedGiftFile($file, string $type): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $safeName = preg_replace('/[^a-zA-Z0-9_-]+/', '-', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $safeName = trim($safeName, '-') ?: 'gift';
        $fileName = gmdate('YmdHis').'-'.uniqid().'-'.$safeName.'.'.$extension;
        $relativeDir = 'store/gift/'.$type;
        $targetDir = base_path($relativeDir);

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $file->move($targetDir, $fileName);

        return $relativeDir.'/'.$fileName;
    }

    private function forgetGiftCache(): void
    {
        Cache::forget('gift_data');
    }

    public static function categoryLabel($category): string
    {
        return self::GIFT_CATEGORIES[(int) $category] ?? 'Frame';
    }
    public function AudioBrdBackgroundIndex()
    {
        $this->ensureAudioBackgroundAccess();

        $data = BrdBackground::where('is_defult', 1)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($item) {
                $item->preview_url = $this->backgroundPreviewUrl($item->image);
                return $item;
            });

        return view('backend.setting.audio_brd_background', compact('data'));
    }

    public function AudioBrdBackgroundUpdate(Request $request, $id)
    {
        $this->ensureAudioBackgroundAccess();

        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $item = BrdBackground::findOrFail($id);
        $directory = base_path('store/brd_background');
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }

        $previousPath = $item->image ? base_path(ltrim((string) $item->image, '/')) : null;
        $image = $request->file('image');
        $originalBase = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $safeBase = preg_replace('/[^A-Za-z0-9_-]+/', '-', (string) $originalBase);
        $safeBase = trim((string) $safeBase, '-');
        if ($safeBase === '') {
            $safeBase = 'background';
        }

        $fileName = gmdate('YmdHis') . '-' . uniqid() . '-' . $safeBase . '.webp';
        $imageFile = Image::make($image->getRealPath())->orientate()->fit(1066, 1600);
        $this->saveOptimizedWebp($imageFile, $directory . DIRECTORY_SEPARATOR . $fileName);

        $item->image = 'store/brd_background/' . $fileName;
        $item->save();

        $this->removeOldBackgroundFile($previousPath, $directory, base_path($item->image));

        return redirect()->back()->with([
            'success' => 'Audio board background updated successfully.',
            'messege' => 'Audio board background updated successfully.',
            'alert-type' => 'success',
        ]);
    }

    private function ensureAudioBackgroundAccess(): void
    {
        if (class_exists(\App\Models\AdminParmisiton::class)
            && method_exists(\App\Models\AdminParmisiton::class, 'allowed')
            && !\App\Models\AdminParmisiton::allowed(auth()->id(), 'sidebar_setting_audio_background')
        ) {
            abort(403, 'Audio board background access denied.');
        }
    }

    private function backgroundPreviewUrl($path): string
    {
        $path = trim((string) $path);
        if ($path === '') {
            return '';
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }

    private function removeOldBackgroundFile($oldPath, $directory, $newAbsolutePath): void
    {
        if (!$oldPath) {
            return;
        }

        $directoryReal = realpath($directory);
        $oldReal = realpath($oldPath);
        $newReal = realpath($newAbsolutePath);

        if (!$directoryReal || !$oldReal) {
            return;
        }

        if ($newReal && $oldReal === $newReal) {
            return;
        }

        if (strpos($oldReal, $directoryReal) === 0 && File::exists($oldReal)) {
            File::delete($oldReal);
        }
    }

    private function saveOptimizedWebp($image, string $absolutePath): void
    {
        foreach ([88, 82, 76, 70, 64, 58, 52, 46] as $quality) {
            $image->encode('webp', $quality)->save($absolutePath);
            if (File::exists($absolutePath) && File::size($absolutePath) <= 102400) {
                return;
            }
        }

        while (File::exists($absolutePath) && File::size($absolutePath) > 102400 && $image->width() > 720) {
            $image->resize(max(720, (int) floor($image->width() * 0.9)), null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image->encode('webp', 52)->save($absolutePath);
        }
    }
}
