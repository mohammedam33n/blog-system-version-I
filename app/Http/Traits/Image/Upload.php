<?php

namespace App\Http\Traits\Image;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

trait Upload
{
    protected function uploadImage($request, $path, $post)
    {
        if (isset($request->images)) {
            $i = 1;
            foreach ($request->images as $file) {

                $filename = $post->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();

                Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path($path . $filename), 100);

                $post->media()->create([
                    'file_name' => $filename,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                ]);

                $i++;
            }
        } else {
            $filename = Str::slug($post->username) . '.' . $request->image->getClientOriginalExtension();
            Image::make($request->image->getRealPath())->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($path . $filename), 100);
            $request->merge(['user_image' => $filename]);
        }
    }
}
