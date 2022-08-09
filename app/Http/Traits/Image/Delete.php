<?php

namespace App\Http\Traits\Image;

use Illuminate\Support\Facades\File;

trait Delete
{


    protected function destroyImage($imagePath)
    {
        if (File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }
        return true;
    }



    //$this->removeImage(Category::Category_PATH . $category->image);
}
