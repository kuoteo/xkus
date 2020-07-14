<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * homepage 展示产品信息
     * @author kuoteo
     */
    public function product(){
        $product = Product::paginate(5);
        return view('admin.home',compact('product'));
    }
    /**
     * importIndex 产品信息导入页面
     * @author kuoteo
     */
    public function importIndex(){
        return view('admin.product.import');
    }
    /**
     * import 产品信息导入
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
            //图片压缩
            $imgurl = substr($fileload, 1, strlen($fileload));
            $img->compress($imgurl);

            $product = new Product();
            $data = $request->input('product');
            $product->title = $data['title'];
            $product->content = $data['content'];
            $product->upload_time = time();
            $product->img_path = $fileload;
            if ($product->save()) {
                flash('操作成功');
            }
        }
        return view('admin.product.import');
    }
    /**
     * updateIndex 产品信息更新
     * @author kuoteo
     * @param  [type] Request $request [description]
     * @param  [type] $id [description]
     * @return [type]       [description]
     */
    public function updateIndex(Request $request,$id){
        $product = Product::find($id);

        if($request->isMethod('post')){
            $data = $request->input('product');
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

                $basename=pathinfo($product->img_path)['basename'];
                Storage::disk('uploads')->delete($basename);

                $product->img_path = $fileload;
            }
            $product->title = $data['title'];
            $product->content = $data['content'];
            $product->upload_time = time();
            if ($product->save()) {
                flash('操作成功');
                return redirect()->route('admin.product.update.index',$id);
            }
        }
        return view('admin.product.update',compact('product'));
    }
    /**
     * delete 产品信息删除
     * @author kuoteo
     * @param  [type] $id [description]
     * @return [type]       [description]
     */
    public function delete($id){
        $product = Product::find($id);
        $basename=pathinfo($product->img_path)['basename'];
        if($product->delete()&&Storage::disk('uploads')->delete($basename)){
            flash('删除成功');
            return back();
        }
        else{
        flash('删除失败');
            return back();
        }
    }
    /**
     * flushcache 清空产品信息API数据
     * @author kuoteo
     */
    public function flushcache(){
        Cache::forget('productshow');
        flash('清空缓存成功');
        return back();
    }

}
