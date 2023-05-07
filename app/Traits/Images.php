<?php 

namespace App\Traits;

use App\Models\Image;
use App\Http\Libraries\Uploader;
use App\Models\ProductPicture;

trait Images {
    
    public function saveImages($product, $request) {
        $productImages = [];
        $images = $request->file('images');
        $uploader = new Uploader();
        if (count($images) > 0) {
            foreach ($images as $key => $img) {
                $uploader->setFile($img);
                if ($uploader->isValidFile()) {
                    $uploader->upload('products/'.$product->id, $uploader->fileName);
                    if ($uploader->isUploaded()) {
                        $productImages[] = new ProductPicture([
                            'image' => $uploader->getUploadedPath(),
                        ]);
                    }
                }
            }
        }

        if (count($productImages) > 0) {
            $product->productPictures()->saveMany($productImages);
        }
    }
    
}