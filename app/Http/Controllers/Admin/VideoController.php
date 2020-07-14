<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * video 展示视频信息
     * @author kuoteo
     */
    public function video(){
        $videoheader = Video::where('type','=', 0)->paginate(5);
        $videoing = Video::where('type','=', 1)->paginate(5);
        $videojump = Video::where('type','=', 2)->paginate(5);
        return view('admin.video.video',compact('videoheader','videoing','videojump'));
    }
    /**
     * importIndex 视频信息导入页面
     * @author kuoteo
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function importIndex($type){
            return view('admin.video.import',compact('type'));
    }
    /**
     * import 视频信息导入
     * @author kuoteo
     * @param  [type] Request $request [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function import(Request $request,$type)
    {
        if($request->isMethod('post')){
            $imgfile = $request->file('img');
            if (!$request->hasFile('img')){
                flash('文件获取失败')->error();
            }
            //上传原图
            $img = new imagesController();
            $imgload=$img->insert($imgfile);

            //图片压缩
            $imgurl = substr($imgload, 1, strlen($imgload));
            $img->compress($imgurl);

            //当type==1时，即上传在线视频
            if($type==1){
                if (!$request->hasFile('video')){
                    flash('文件获取失败')->error();
                }
                $videofile = $request->file('video');
                $videoload=$img->insert($videofile);
            }

            $video = new Video();
            $data = $request->input('video');
            $video->title = $data['title'];
            $video->content = $data['content'];
            $video->author = $data['author'];
            $video->tag = $data['tag'];
            $video->sort = $data['sort'];
            $video->upload_time = time();
            $video->type=$type;
            $video->media_path = $imgload;
            if($type==1){$video->url=$videoload;}//在线视频->视频路径
            if(isset($data['url'])&&$type==2){                //头像->null
                $video->url=$data['url'];//跳转视频->跳转路径
            }
            if ($video->save()) {
                flash('操作成功');
                return redirect()->route('admin.video.import.index',$type);
            }
        }
        return view('admin.video.import.index',$type);
    }
    /**
     * updateIndex 视频信息更新
     * @author kuoteo
     * @param  [type] Request $request [description]
     * @param  [type] $type [description]
     * @param  [type] $id [description]
     * @return [type]       [description]
     */
    public function updateIndex(Request $request,$type,$id){
        $video = Video::find($id);
        if($request->isMethod('post')){
            if(($imgfile = $request->file('img'))!=null) {
                if (!$request->hasFile('img')) {
                    flash('文件获取失败')->error();
                }
                //上传原图
                $img = new imagesController();
                $imgload=$img->insert($imgfile);
                //图片压缩
                $imgurl = substr($imgload, 1, strlen($imgload));
                $img->compress($imgurl);

                $basename=pathinfo($video->media_path)['basename'];
                Storage::disk('uploads')->delete($basename);

                $video->media_path = $imgload;
            }
            if(($videofile = $request->file('video'))!=null) {
                if (!$request->hasFile('video')) {
                    flash('文件获取失败')->error();
                }
                $img = new imagesController();
                $videoload=$img->insert($videofile);

                $basename=pathinfo($video->url)['basename'];
                Storage::disk('uploads')->delete($basename);

                $video->url=$videoload;
            }

            $data = $request->input('video');
            $video->title = $data['title'];
            $video->content = $data['content'];
            $video->author = $data['author'];
            $video->tag = $data['tag'];
            $video->sort = $data['sort'];
            if(isset($data['url'])){
                $video->url=$data['url'];}
            if(isset($data['videoname'])){
                $basename=pathinfo($video->url)['basename'];
                Storage::disk('uploads')->delete($basename);
                $video->url='/storage/uploads/'.$data['videoname'];
            }
            $video->upload_time = time();
            if ($video->save()) {
                flash('操作成功');
                return redirect()->route('admin.video.update.index',[$type,$id]);
            }
        }
        return view('admin.video.update',compact('video','type'));
    }
    /**
     * delete 视频信息删除
     * @author kuoteo
     * @param  [type] $id [description]
     * @return [type]       [description]
     */
    public function delete($id){
        $video = Video::find($id);
        if($video->type==1){
            $videoname=pathinfo($video->url)['basename'];
            Storage::disk('uploads')->delete($videoname);
        }
        $basename=pathinfo($video->media_path)['basename'];
        if($video->delete()&&Storage::disk('uploads')->delete($basename)){
            flash('删除成功');
            return back();
        }
        else{
            flash('删除失败');
            return back();
        }
    }
    /**
     * flushcache 清空视频信息API数据
     * @author kuoteo
     */
    public function flushcache(){
        Cache::forget('videoheaderx');
        Cache::forget('videoingx');
        Cache::forget('videojumpx');
        flash('清空缓存成功');
        return back();
    }
}
