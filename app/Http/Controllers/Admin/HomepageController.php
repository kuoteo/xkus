<?php

namespace App\Http\Controllers\Admin;

use App\Models\Homepage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;


class HomepageController extends Controller
{
    /**
     * homepage 展示星空网首页信息
     * @author kuoteo
     */
    public function homepage(){
        $homebanner = Homepage::where('type','=', 0)->paginate(5);
        $homecontent = Homepage::where('type','=', 1)->paginate(5);
        return view('admin.Homepage.homepage',compact('homebanner','homecontent'));
    }
    /**
     * importIndex 首页信息导入页面
     * @author kuoteo
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function importIndex($type){
        if($type == 0){
            $model = "首页轮播海报导入";
        }
        elseif($type == 1){
            $model = "首页简介海报导入";
        }
        else {
            flash('未允许操作');
            return back();
        }
        return view('admin.Homepage.import',compact('type','model'));
    }
    /**
     * import 首页信息导入
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

            //图片压缩
            $imgurl = substr($fileload, 1, strlen($fileload));
            $img->compress($imgurl);

            $homepage = new Homepage();
            $data = $request->input('homepage');
            $homepage->title = $data['title'];
            $homepage->s_title = $data['s_title'];
            $homepage->url = $data['url'];
            $homepage->img_path = $fileload;
            $homepage->type=$type;
            if ($homepage->save()) {
                flash('操作成功');
                return redirect()->route('admin.homepage.import.index',$type);
            }
        }
        return view('admin.homepage.import.index',$type);
    }
    /**
     * updateIndex 首页信息更新
     * @author kuoteo
     * @param  [type] Request $request [description]
     * @param  [type] $id [description]
     * @return [type]       [description]
     */
    public function updateIndex(Request $request,$id){
        $homepage = Homepage::find($id);
        if($request->isMethod('post')){
            $data = $request->input('homepage');
            if(($file = $request->file('img'))!=null){
                if (!$request->hasFile('img')){
                    flash('文件获取失败')->error();
                }
                //上传原图
                $img = new imagesController();
                $fileload=$img->insert($file);
                //图片压缩
                $imgurl = substr($fileload, 1, strlen($fileload));
                $img->compress($imgurl);

                $basename=pathinfo($homepage->img_path)['basename'];
                Storage::disk('uploads')->delete($basename);

                $homepage->img_path = $fileload;
            }
            $homepage->title = $data['title'];
            $homepage->s_title = $data['s_title'];
            $homepage->url = $data['url'];
            if ($homepage->save()) {
                flash('操作成功');
                return redirect()->route('admin.homepage.update.index',$id);
            }
        }
        return view('admin.Homepage.update',compact('homepage'));
    }
    /**
     * delete 首页信息删除
     * @author kuoteo
     * @param  [type] $id [description]
     * @return [type]       [description]
     */
    public function delete($id){
        $homepage = Homepage::find($id);
        $basename=pathinfo($homepage->img_path)['basename'];
        if($homepage->delete()&&Storage::disk('uploads')->delete($basename)){
            flash('删除成功');
            return back();
        }
        else{
            flash('删除失败');
            return back();
        }
    }
    /**
     * flushcache 清空首页信息API数据
     * @author kuoteo
     */
    public function flushcache(){
        Cache::forget('homebanner');
        Cache::forget('homecontent');
        flash('清空缓存成功');
        return back();
    }

}
