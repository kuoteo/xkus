<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

class imagesController extends Controller
{
    //添加水印
    public function insert_logo($imgurl){
        Image::configure(array('driver' => 'imagick'));
        $width = Image::make($imgurl)->width();
        $height = Image::make($imgurl)->height();
        $image = Image::make($imgurl);
        if($width>=$height){
            $imagelogo = Image::make('storage/uploads/xklogo.png')->resize($width/10, null, function($constraint){		// 调整图像的宽到300，并约束宽高比(高自动)
                $constraint->aspectRatio();
            });
        }
        else{
            $imagelogo = Image::make('storage/uploads/xklogo.png')->resize(null, $height/10,function($constraint){		// 调整图像的宽到300，并约束宽高比(高自动)
                $constraint->aspectRatio();
            });
        }
        $image->insert($imagelogo, 'bottom-right', 15, 10);
        $image->save($imgurl);
        $image->destroy();
    }
    //原图上传
    public function insert($file){
        //后缀名
        $ext = $file->getClientOriginalExtension();
        //临时绝对路径
        $realPath = $file->getRealPath();
        //设置时间名为文件名
        $filename = date("y-m-d").'-'. uniqid() . '.' . $ext;
        //保存到磁盘（本地）
        Storage::disk('uploads')->put($filename,file_get_contents($realPath));
        $fileload='/storage/uploads/'.$filename;
        return $fileload;
    }
    //缩略图上传
    public function thumbnail($imgurl,$prefix){
        Image::configure(array('driver' => 'imagick'));
        $size=Image::make($imgurl)->filesize()/1024;
        $width = Image::make($imgurl)->width();
        switch ($size){
            case $size>4096:
                $width = $width/30;
                break;
            case $size>2048&&$size<=4096:
                $width = $width/20;
                break;
            case $size>1024&&$size<=2048:
                $width = $width/10;
                break;
            case $size>512&&$size<=1024:
                $width = $width/5;
                break;
            case $size>100&&$size<=512:
                $width = $width/3;
                break;
        }
        $image = Image::make($imgurl);
        $image->resize($width, null, function($constraint){		// 调整图像的宽到300，并约束宽高比(高自动)
            $constraint->aspectRatio();
        });
        $thum_fileload='/storage/uploads/thum'.$prefix;
        $thum_name='storage/uploads/thum'.$prefix;
        $image->save($thum_name);
        $image->destroy();
        return $thum_fileload;
    }
    //图片压缩
    public function compress($imgurl){
        Image::configure(array('driver' => 'imagick'));
        $size=Image::make($imgurl)->filesize()/1024;
        $width = Image::make($imgurl)->width();
        $height = Image::make($imgurl)->height();
        $image = Image::make($imgurl);
        if($size>200) {
            if ($width >= $height) {
                $image->resize(null, 400, function ($constraint) {        // 调整图像的宽到300，并约束宽高比(高自动)
                    $constraint->aspectRatio();
                });
            } else {
                $image->resize(400, null, function ($constraint) {        // 调整图像的宽到300，并约束宽高比(高自动)
                    $constraint->aspectRatio();
                });
            }
            $image->save();
            $image->destroy();
        }
    }
}
