<?php

namespace App\Models;

use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Article;
use EasyWeChat\Message\News;
use Illuminate\Database\Eloquent\Model;
use DB;

class Template extends Model
{

    static public function index(){ }

    static public function test(){
        //87ps5pzIifU-IdJDVdG-GWTBhgqwGz0Wyk51KSGAAlo

        /*$media_id_img = self::upload_img("/img/1-96.jpg")->media_id;
        var_dump($media_id_img);
        $media_id_article =  self::upload_article('title' , $media_id_img , '$content' , 'www.baidu.com' , '$digest' )->media_id;
        return self::send_all_article($media_id_article);*/
//        return self::get_sucai_list();
//        return self::send_preview("87ps5pzIifU-IdJDVdG-GShiZka0gx8WemYMvYkxmFA");


//        return self::upload_article('title' , $media_id , '$content' , 'www.baidu.com' , '$digest' );
//        return self::send_news ('测试','测试一下','www.baidu.com',$media_id_img,'oefvgwGWrvWNEihktyC4OMLgkNZI');
    }

    /*
     * 获取永久素材列表
     * */
    static public function get_sucai_list(){
        $app = app('wechat');
        $material = $app->material;
        return $material->lists("news");
    }

    /*
     * 发送预览图文消息
     * */
    static public function send_preview($media_id){
        $app = app('wechat');
        $broadcast = $app->broadcast;
        $result = $broadcast->previewNews($media_id, "oefvgwGWrvWNEihktyC4OMLgkNZI");
        return $result;

    }

    /**上传永久素材图片
     * @param $path     图片路径
     * @return
     * {
           "media_id":MEDIA_ID,
           "url":URL
        }
     */
    static public function upload_img( $path ){
        $app = app('wechat');
        $material = $app->material;
        $result = $material->uploadImage(dirname(__FILE__).'/../../public/'.$path);  // 请使用绝对路径写法！除非你正确的理解了相对路径（好多人是没理解对的）！
        return $result;
    }

    /**上传永久图文消息
     * @param $title        标题
     * @param $mediaId      封面图片mediaId
     * @param $content      图文内容
     * @param $url          链接
     * @param $digest       摘要
     */
    static public function upload_article( $title , $mediaId , $content , $url , $digest ){
        $app = app('wechat');
        $material = $app->material;
        $article = new Article([
            'title' => $title,
            'thumb_media_id' => $mediaId,
            'content'=>$content,
            'digest'=>$digest,
            'url'=>$url
        ]);
        return $material->uploadArticle($article);
    }

    /**发送图文给所有人
     * @param $mediaId
     * @return mixed
     */
    static public function send_all_article( $mediaId ){
        $app = app('wechat');
        $broadcast = $app->broadcast;
        return $broadcast->sendNews( $mediaId , self::get_openid_all()->toarray() );
    }

    /**发送图文消息给制定openid
     * @param $title
     * @param $description
     * @param $url
     * @param $image
     * @param $openId
     */
    static public function send_news ($title,$description,$url,$image,$openId){
        $app = app('wechat');
        $news = new News([
            'title'       => $title,
            'description' => $description,
            'url'         => $url,
            'image'       => $image,
        ]);
        $result = $app->staff->message($news)->to($openId)->send();
        return $result;
    }

    static public function get_openid_all(){
        $result = DB::table('wx_user')
            ->where('is_subscribe',1)
            ->pluck('openid');
        return $result;
    }

}