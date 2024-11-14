<?php
namespace App\traits;

use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

Trait savephoto {
    public function SaveImage($file,$flodername,$width = 400,$height = 400){
        
            $manager = new ImageManager(new Driver());
            //fetch image from request
           
            $ext=time().$file->getClientOriginalName();
            //resize image
            $img = $manager->read($file);
            $img = $img->resize($width,$height);
            //save image in folder
            $img=$img->toJpeg(80)->save(public_path('/storage/'.$flodername.'/'.$ext));
            $path = $flodername.'/'.$ext;
            return $path;
            
            
        
      

    }

}
?>