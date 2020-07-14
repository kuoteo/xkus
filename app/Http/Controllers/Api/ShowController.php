<?php

namespace App\Http\Controllers\Api;

use App\Models\Homepage;
use App\Models\Photo;
use App\Models\Product;
use App\Models\Video;
use App\Models\Vision;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{
    private $ip = "https://xingkong.gqt.gcu.edu.cn/mobile";
    /**
     * @return \Illuminate\Http\JsonResponse
     * 产品Api接口
     */
    public function productshow()
    {
        if (!Cache::has('productshow')) {     //设置缓存 减少查库
            $products = Product::all();     //产品数据
            $productshow = array();         //产品
            foreach ($products as $v => $product) {
                $productshow[] = array(
                    'title' => $product['title'],
                    'content' => $product['content'],
                    'img_path' => $this->ip . $product['img_path'],
                );
            }
            Cache::forever('productshow', $productshow);
        }
        $productshows = Cache::get('productshow');
        return response()
            ->json(
                $productshows
            );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 首页Api接口
     */
    public function homepageshow()
    {
        if(!Cache::has('homebanner')||!Cache::has('homecontent')){//设置缓存 减少查库
            $homepages = Homepage::all();   //首页数据
            $homebanner = array();          //首页banner
            $homecontent = array();         //首页简介
            foreach ($homepages as $v => $homepage) {
                if ($homepage['type'] == '0') {
                    $homebanner[] = array(
                        'title' => $homepage['title'],
                        's_title' => $homepage['s_title'],
                        'url' => $homepage['url'],
                        'img_path' => $this->ip . $homepage['img_path'],
                    );
                }
                if ($homepage['type'] == '1') {
                    $homecontent[] = array(
                        'title' => $homepage['title'],
                        's_title' => $homepage['s_title'],
                        'url' => $homepage['url'],
                        'img_path' => $this->ip . $homepage['img_path'],
                    );
                }
            }
            Cache::forever('homebanner',$homebanner);
            Cache::forever('homecontent',$homecontent);
        }
        $homebannerCache=Cache::get('homebanner');
        $homecontentCache=Cache::get('homecontent');
        return response()
            ->json([
                    'homebanner' => $homebannerCache,
                    'homecontent' => $homecontentCache
                ]
            );
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     * 摄影Api接口
     */
    public function photoshow()
    {
        if (!Cache::has('photobanner') || !Cache::has('photography')) {//设置缓存 减少查库
            $photos = Photo::all();                 //摄影数据
            $photobanner = array();                 //摄影banner
            $photography = array();                 //摄影图及摄影师头像
            foreach ($photos as $v => $photo) {
                if ($photo['type'] == '0') {
                    $photobanner[] = array(
                        'media_path' => $this->ip . $photo['media_path'],
                    );
                }
                if ($photo['type'] == '1') {
                    //通过摄影图作者获取头像和艺名
                    foreach ($photos as $veer => $photoer) {
                        if ($photoer['type'] == '2' && $photoer['author'] == $photo['author']) {
                            $Stage = $photoer['title'];
                            //$header = $photoer['media_path'];
                            $thum_header = $photoer['thumbnail'];
                        }
                    }
                    $photography[] = array(
                        'title' => $photo['title'],
                        'content' => $photo['content'],
                        'author' => $Stage,
                        //'header' => $header,
                        'thum_header' => $this->ip . $thum_header,
                        'upload_time' => $photo['upload_time'],
                        'tag' => $photo['tag'],
                        'media_path' => $this->ip . $photo['media_path'],
                        'thumbnail' => $this->ip . $photo['thumbnail']
                    );
                }
            }
            Cache::forever('photobanner', $photobanner);
            Cache::forever('photography', $photography);
        }
        $photobanners = Cache::get('photobanner');
        $photographys = Cache::get('photography');
        return response()
            ->json([
                    'photobanner' => $photobanners,
                    'photo' => $photographys
                ]
            );
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     * 视频Api接口
     */
    public function videoshow()
    {
        if(!Cache::has('videoheaderx')
            || !Cache::has('videoingx')
            || !Cache::has('videojumpx')){//设置缓存 减少查库
            $sorts = DB::table('video')->distinct()->get(['sort']);//概括不重复的全部类别
            $videoheaders = Video::where('type', '0')->get();//logo
            $videoings = Video::where('type', '1')->get();//在线视频
            $videojumps = Video::where('type', '2')->get();//跳转视频
            $sortx = array();                    //摄影板块判断
            $videoheaderx = array();
            $videoingx = array();
            $videojumpx = array();
            foreach ($sorts as $keysort => $sort) {
                $sortx[$keysort] = $sort->sort;
                //匹配同类别的logo
                foreach ($videoheaders as $keyheader => $video) {
                    if ($video['sort'] == $sortx[$keysort]) {
                        $videoheaderx[$keysort][] = array(
                            'title' => $video['title'],
                            'content' => $video['content'],
                            'upload_time' => $video['upload_time'],
                            'media_path' => $this->ip . $video['media_path'],
                        );
                    }
                }
                //匹配同类别的在线视频
                foreach ($videoings as $keying => $videoing) {
                    if ($videoing['sort'] == $sortx[$keysort]) {
                        $videoingx[$keysort][] = array(
                            'title' => $videoing['title'],
                            'content' => $videoing['content'],
                            'author' => $videoing['author'],
                            'upload_time' => $videoing['upload_time'],
                            'tag' => $videoing['tag'],
                            'media_path' => $this->ip . $videoing['media_path'],
                            'url' => $this->ip . $videoing['url']
                        );
                    }
                }
                //匹配同类别的跳转视频
                foreach ($videojumps as $keyjump => $videojump) {
                    if ($videojump['sort'] == $sortx[$keysort]) {
                        $videojumpx[$keysort][] = array(
                            'title' => $videojump['title'],
                            'content' => $videojump['content'],
                            'author' => $videojump['author'],
                            'upload_time' => $videojump['upload_time'],
                            'tag' => $videojump['tag'],
                            'media_path' => $this->ip . $videojump['media_path'],
                            'url' => $videojump['url']
                        );
                    }
                }
            }
            Cache::forever('videoheaderx',$videoheaderx);
            Cache::forever('videoingx', $videoingx);
            Cache::forever('videojumpx', $videojumpx);
        }
        $videoheaderCache=Cache::get('videoheaderx');
        $videoingCache=Cache::get('videoingx');
        $videojumpCache=Cache::get('videojumpx');
        return response()
            ->json([
                    'video' => array(
                        'videoheader' => $videoheaderCache,
                        'videoing' => $videoingCache,
                        'videojump' => $videojumpCache),
                ]
            );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 视觉Api接口
     */
    public function visionshow()
    {
        if(!Cache::has('Visionshow')){//设置缓存 减少查库
            $Visions = Vision::all();
            $Visionshow = array();
            foreach ($Visions as $v => $Vision) {
                $Visionshow[] = array(
                    'title' => $Vision['title'],
                    'content' => $Vision['content'],
                    'img_path' => $this->ip . $Vision['img_path'],
                    'thumbnail' => $this->ip . $Vision['thumbnail']
                );
            }
            Cache::forever('Visionshow',$Visionshow);
        }
        $visionshowCache = Cache::get('Visionshow');
        return response()
            ->json(
                $visionshowCache
            );
    }
}
