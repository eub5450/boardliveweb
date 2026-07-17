<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
class SliderController extends Controller
{
    public function Index()
    {
    	$sliders=Slider::orderBy('id', 'desc')->get()->map(function ($slider) {
            $slider->image_url = $this->publicSliderUrl($slider->image);
            return $slider;
        });
    	return view('backend.slider.index',compact('sliders'));
    }
    public function Store(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $image = $request->file('image');
        if (!$image->isValid()) {
            throw ValidationException::withMessages(['image' => 'Banner upload failed.']);
        }

        $imageName = gmdate('YmdHis').'-'.uniqid().'.'.strtolower($image->getClientOriginalExtension());
        $imagePath = 'store/banner/';
        $targetDir = base_path($imagePath);
        if (!File::isDirectory($targetDir)) {
            File::makeDirectory($targetDir, 0775, true, true);
        }

        $image->move($targetDir, $imageName);
        @chmod($targetDir.'/'.$imageName, 0664);

        $slider=new Slider;
        $slider->image=$imagePath.$imageName;
        $slider->save();
        Cache::forget('v4:broadlive:slider_list_v1');
        try { Redis::del('broadlive:slider'); } catch (\Throwable $e) {}

        $notification=array(
            'messege'=>'Slider Update Successfully!',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }
    public function Remove($id)
    {
    	 $slider=Slider::find($id);
         if ($slider) {
             $slider->delete();
         }
         Cache::forget('v4:broadlive:slider_list_v1');
         try { Redis::del('broadlive:slider'); } catch (\Throwable $e) {}
         $notification=array(
                'messege'=>'Slider Removed Successfully!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }

    private function publicSliderUrl($image): string
    {
        $path = trim((string) $image);
        if ($path === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $path = preg_replace('#^public/#', '', ltrim($path, '/'));
        return url('/'.ltrim($path, '/'));
    }
}
