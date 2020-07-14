<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vision;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class VisionController extends Controller
{
    /**
     * vision 展示视觉信息
     * @author kuoteo
     */
    public function vision(){
        $vision = Vision::paginate(5);
        return view('admin.vision.vision',compact('vision'));
    }
    /**
     * importIndex 摄影信息导入页面
     * @author kuoteo
     */
    public function importIndex(){
        return view('admin.vision.import');
    }
    /**
     * import 摄影信息导入
     * @author kuoteo
     * @param  [type] Request $request [description]
     * @return [type]       [description]
     */
    public function import(Request $request){
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

            $vision = new vision();
            $data = $request->input('vision');
            $vision->title = $data['title'];
            $vision->content = $data['content'];
            $vision->img_path = $fileload;
            $vision->thumbnail = $thumbnail;
            $vision->upload_time = time();
            if ($vision->save()) {
                flash('操作成功');
                return redirect()->route('admin.vision.import.index');
            }
        }
        return view('admin.vision.import.index');
    }
    /**
     * updateIndex 视觉信息更新
     * @author kuoteo
     * @param  [type] Request $request [description]
     * @param  [type] $id [description]
     * @return [type]       [description]
     */
    public function updateIndex(Request $request,$id){
        $vision = Vision::find($id);

        if($request->isMethod('post')){
            $data = $request->input('vision');
            if(($file = $request->file('img'))!=null){
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

                //删除原文件
                $imgname=pathinfo($vision->img_path)['basename'];
                $thumname=pathinfo($vision->thumbnail)['basename'];
                Storage::disk('uploads')->delete($imgname,$thumname);

                $vision->img_path = $fileload;
                $vision->thumbnail = $thumbnail;
            }
            $vision->title = $data['title'];
            $vision->content = $data['content'];
            $vision->upload_time = time();
            if ($vision->save()) {
                flash('操作成功');
                return redirect()->route('admin.vision.update.index',$id);
            }
        }
        return view('admin.vision.update',compact('vision'));
    }
    /**
     * delete 视觉信息删除
     * @author kuoteo
     * @param  [type] $id [description]
     * @return [type]       [description]
     */
    public function delete($id){
        $vision = Vision::find($id);
        $imgname=pathinfo($vision->img_path)['basename'];
        $thumname=pathinfo($vision->thumbnail)['basename'];
        if($vision->delete()&&Storage::disk('uploads')->delete($imgname,$thumname)){
            flash('删除成功');
            return back();
        }
        else{
            flash('删除失败');
            return back();
        }
    }
    /**
    * flushcache 清空视觉信息API数据
    * @author kuoteo
    */
    public function flushcache(){
        Cache::forget('Visionshow');
        flash('清空缓存成功');
        return back();
    }

}
