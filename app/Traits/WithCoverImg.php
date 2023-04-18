<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait WithCoverImg {
/*  private function storeCoverImg($request, &$data, $folder = "coverImgs") {
    if ($request->hasFile("coverImg")) {
      $data["coverImg"] = $request->file("coverImg")->storePublicly($folder);
    }
  }*/
  
  private function upsertCoverImg($request, &$data, $folder = "coverImgs", $instance = null) {
    if ($request->hasFile("coverImg")) {
      
      // if already has an image, delete the current one and then upload the new one
      if ($instance && $instance->coverImg) {
        Storage::delete($instance->coverImg);
      }
      
      $data["coverImg"] = $request->file("coverImg")->storePublicly($folder);
    }
  }
  
  private function deleteCoverImg($coverImg = null) {
    if ($coverImg) {
      Storage::delete($coverImg);
    }
  }
}
