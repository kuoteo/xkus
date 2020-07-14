<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * photo 展示摄影信息
     * @author kuoteo
     */
    public function photo(){
        $photobanner = Photo::where('type','=', 0)->paginate(5);
        $photo = Photo::where('type','=', 1)->paginate(5);
        $photoer = Photo::where('type','=', 2)->paginate(5);
        return view('admin.photo.photo',compact('photobanner','photo','photoer'));
    }
    /**
     * importIndex 摄影信息导入页面
     * @author kuoteo
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function importIndex($type){

        return view('admin.photo.import',compact('type'));
    }

    /**
     * import 摄影信息导入
     * @author kuoteo
     * @param  [type] Request $request [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function import(Request $request,$type){
        if($request->isMethod('post')){
            $file = $request->file('img');
            if (!$request->hasFile('img')){
                flash('文件获取失败')->error();
            }

            //上传原图
            $img = new imagesController();
            $fileload=$img->insert($file);

            //添加水印
            $imgurl = substr($fileload, 1, strlen($fileload));
            $img->insert_logo($imgurl);

            //上传缩略图
            $prefix = substr($fileload, 17, strlen($fileload));
            $thumbnail=$img->thumbnail($imgurl,$prefix);

            $photo = new Photo();
            $data = $request->input('photo');
            $photo->title = $data['title'];
            $photo->content = $data['content'];
            $photo->author = $data['author'];
            $photo->tag = $data['tag'];
            $photo->upload_time = time();
            $photo->type=$type;
            $photo->media_path = $fileload;
            $photo->thumbnail = $thumbnail;
            if ($photo->save()) {
                flash('操作成功');
                return redirect()->route('admin.photo.import.index',$type);
            }
        }
        return view('admin.photo.import.index',$type);
    }

    /**
     * updateIndex 摄影信息更新
     * @author kuoteo
     * @param  [type] Request $request [description]
     * @param  [type] $type [description]
     * @param  [type] $id [description]
     * @return [type]       [description]
     */
    public function updateIndex(Request $request,$type,$id){
        $photo = Photo::find($id);
        if($request->isMethod('post')){
            $data = $request->input('photo');
            if(($file = $request->file('img'))!=null) {
                if (!$request->hasFile('img')) {
                    flash('文件获取失败')->error();
                }
                //上传原图
                $img = new imagesController();
                $fileload=$img->insert($file);

                //添加水印
                $imgurl = substr($fileload, 1, strlen($fileload));
                $img->insert_logo($imgurl);

                //上传缩略图
                $prefix = substr($fileload, 17, strlen($fileload));
                $thumbnail=$img->thumbnail($imgurl,$prefix);

                //删除原文件
                $medianame=pathinfo($photo->media_path)['basename'];
                $thumname=pathinfo($photo->thumbnail)['basename'];
                Storage::disk('uploads')->delete($medianame,$thumname);

                $photo->media_path = $fileload;
                $photo->thumbnail = $thumbnail;
            }
            $photo->title = $data['title'];
            $photo->content = $data['content'];
            $photo->author = $data['author'];
            $photo->tag = $data['tag'];
            $photo->upload_time = time();
            if ($photo->save()) {
                flash('操作成功');
                return redirect()->route('admin.photo.update.index',[$type,$id]);
            }
        }
        return view('admin.photo.update',compact('photo','type'));
    }

    /**
     * delete 摄影信息删除
     * @author kuoteo
     * @param  [type] $id [description]
     * @return [type]       [description]
     */
    public function delete($id){
        $photo = Photo::find($id);
        $medianame=pathinfo($photo->media_path)['basename'];
        $thumname=pathinfo($photo->thumbnail)['basename'];
        if($photo->delete()&&Storage::disk('uploads')->delete($medianame,$thumname)){
            flash('删除成功');
            return back();
        }
        else{
            flash('删除失败');
            return back();
        }
    }
    /**
     * flushcache 清空摄影banner和摄影信息API数据
     * @author kuoteo
     */
    public function flushcache(){
        Cache::forget('photobanner');
        Cache::forget('photography');
        flash('清空缓存成功');
        return back();
    }

}
