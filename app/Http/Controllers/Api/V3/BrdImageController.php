<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\BrdBackground;
use Image;
use Illuminate\Support\Str;
class BrdImageController extends Controller
{
     private $API_TOKEN = "0411f0028cfb768b3a3d96ac3aa37dw3e5";

    // ------------------------------
    // Helper: API Response
    // ------------------------------
    private function apiResponse($message, $data = [], $code = 200)
    {
        return response()->json([
            'message' => $message,
            'images'  => $data,
            'code'    => $code
        ], $code, [], JSON_UNESCAPED_UNICODE);
    }

    // ------------------------------
    // Helper: Load Combined All Images
    // ------------------------------
    private function loadAllImages($user_id)
    {
        $images = [];

        $defaults = BrdBackground::whereNull('user_id')->get();
        foreach ($defaults as $item) {
            $images[] = [
                'id'        => $item->id,
                'image'     => $item->image,
                'is_defult' => 1
            ];
        }

        $myImages = BrdBackground::where('user_id', $user_id)->get();
        foreach ($myImages as $item) {
            $images[] = [
                'id'        => $item->id,
                'image'     => $item->image,
                'is_defult' => 0
            ];
        }

        return $images;
    }

    // ------------------------------
    // INDEX — Get All Background Images
    // ------------------------------
    public function Index(Request $request)
    {
        

        $images = $this->loadAllImages($request->user_id);

        return $this->apiResponse('Audio Brd Background Image List', $images, 200);
    }

    // ------------------------------
    // DELETE — Remove User Background
    // ------------------------------
    public function Delete(Request $request)
    {
        

        $item = BrdBackground::find($request->id);

        if (!$item || $item->user_id === null || $item->is_defult == 1) {
            return $this->apiResponse('You Cant remove this', [], 401);
        }

        // Delete physical file
        $filePath = base_path($item->image);
        $brdRoot = realpath(base_path('store/brd_background'));
        $deleteRealPath = realpath($filePath);
        if ($brdRoot && $deleteRealPath && \Illuminate\Support\Str::startsWith($deleteRealPath, $brdRoot) && File::exists($deleteRealPath)) {
            File::delete($deleteRealPath);
        }

        // Delete database record
        $item->delete();

        $images = $this->loadAllImages($request->user_id);
        return $this->apiResponse('Audio Brd Background Removed', $images, 200);
    }

    // ------------------------------
    // STORE — Upload Background
    // ------------------------------
    public function Store(Request $request)
    {
        

        try {
            $user_id = $request->user_id;

            // Delete previous background
            $oldImage = BrdBackground::where('user_id', $user_id)
                                     ->where('is_defult', 0)
                                     ->first();

            // Process new image upload
            if ($request->has('image')) {
                $imageData = trim((string) $request->image);
                if (strpos($imageData, ',') !== false) {
                    $imageData = substr($imageData, strpos($imageData, ',') + 1);
                }

                $decoded = base64_decode($imageData, true);
                if ($decoded === false || $decoded === '') {
                    $images = $this->loadAllImages($user_id);
                    return $this->apiResponse('Invalid image data', $images, 400);
                }

                $brdDir = base_path('store/brd_background');
                if (! File::isDirectory($brdDir)) {
                    File::makeDirectory($brdDir, 0755, true, true);
                }

                try {
                    $image = Image::make($decoded)->orientate()->fit(1066, 1600);
                } catch (\Throwable $e) {
                    $images = $this->loadAllImages($user_id);
                    return $this->apiResponse('Invalid image data', $images, 400);
                }

                // Save file
                $fileName = 'store/brd_background/' . Str::random(40) . '.webp';
                $this->saveOptimizedWebp($image, base_path($fileName));

            } else {
                $images = $this->loadAllImages($user_id);
                return $this->apiResponse('Invalid image data', $images, 400);
            }

            if ($oldImage) {
                $filePath = base_path($oldImage->image);
                $brdRoot = realpath(base_path('store/brd_background'));
                $oldRealPath = realpath($filePath);
                if ($brdRoot && $oldRealPath && \Illuminate\Support\Str::startsWith($oldRealPath, $brdRoot) && File::exists($oldRealPath)) {
                    File::delete($oldRealPath);
                }
                $oldImage->delete();
            }

            // Save DB record
            $new = new BrdBackground();
            $new->user_id   = $user_id;
            $new->image     = $fileName;
            $new->is_defult = 0;
            $new->save();

            $images = $this->loadAllImages($user_id);

            return $this->apiResponse('Background uploaded successfully', $images, 200);

        } catch (\Exception $e) {

    \Log::error("Background Upload Error: " . $e->getMessage(), [
        'user_id' => $request->user_id,
        'trace'   => $e->getTraceAsString()
    ]);

    $images = $this->loadAllImages($request->user_id);

    return $this->apiResponse(
        'Internal Server Error',
        [
            'error'  => $e->getMessage(),
            'images' => $images
        ],
        500
    );
}

    }

    private function saveOptimizedWebp($image, string $absolutePath): void
    {
        foreach (array(88, 82, 76, 70, 64, 58, 52, 46) as $quality) {
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
