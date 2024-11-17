<?php
namespace App\traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
    public function CheckImageExist($request,$oldImage , $flodername ){
         //if request exists in image delete from folder and add new photo
         if ($request->hasFile('image')) {
            if(File::exists(public_path('storage/'.$oldImage))){
                File::delete(public_path('storage/'.$oldImage));
            }
            $image=$this->SaveImage($request->file('image'),$flodername,600,600); 
         
            return $image;
        }
    }

}
?>