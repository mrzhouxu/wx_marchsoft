<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2017/11/5
 * Time: 15:24
 */

namespace App\Models\Admin\News;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewModel extends Model
{
    use SoftDeletes;
    protected $table = 'march_news';
    protected $primaryKey = 'idmarch_news';
    public $timestamps = false;
    protected $fillable = ['news_title', 'news_content', 'news_date', 'news_publisher', 'active_type', 'news_stick','news_type'];
    protected $dates = ['deleted_at'];

    public function getNews()
    {
        $news = $this->orderBy('news_stick', 'desc')->paginate(10, ['idmarch_news', 'news_title', 'news_content', 'news_date', 'news_publisher', 'news_num','active_type']);
        dd($news[0]);
        return $news;
    }



    public function getNewsItem_show(){
        $news = $this->orderBy('news_stick', 'desc')->paginate(10, ['idmarch_news', 'news_title','news_content', 'news_date', 'news_publisher', 'news_num']);
        return $news;
    }

    public function getNewsTimeItem_show(Request $request){

        $news = $this->where('news_date','>',$request->input('date').'-00 00:00:00')
            ->where('news_date','<',$request->input('date').'-31 23:59:59')
            ->paginate(10,['idmarch_news', 'news_title','news_content', 'news_date', 'news_publisher', 'news_num']);
        return $news;
    }

    public function getNewsItem()
    {
        $news = $this->orderBy('news_stick', 'desc')->paginate(10, ['idmarch_news', 'news_title', 'news_date', 'news_publisher', 'news_num']);
        return $news;
    }

    public function getNew_show(Request $request){
        $id = $request->input('pid');
        $new = $this->where('idmarch_news',$id)->first(['idmarch_news','news_title','news_content','news_date','news_num','news_publisher']);
        $number = $new['news_num'];
        $new['news_num'] = $new['news_num']+1;
        $this->where('idmarch_news',$id)->update(['news_num'=>$number+1]);
        return $new;
    }

    public function getOneNew(Request $request){
        $id = $request->input('pid');
        $new = $this->where('idmarch_news',$id)->first(['idmarch_news','news_title','news_content','news_stick']);
        return $new;;

    }

    public function deleteNews($id){
        $status = $this->destroy($id);
        return $status;
    }

    public function updateNews(Request $request){
        $news = $request->input('news');
        if(!$news['checked']){
            $status = $this->where('idmarch_news',$news['id'])->update(['news_title'=>$news['title'],'news_content'=>$news['content'],'news_stick'=>0]);
        }else{
            $status = $this->where('idmarch_news',$news['id'])->update(['news_title'=>$news['title'],'news_content'=>$news['content']]);
        }
        return $status;

    }


    public function getStick(){
        $data =  $this->withTrashed()->orderBy('news_stick','desc')->limit(1)->get(['news_stick']);
        return $data[0]->news_stick+1;
    }

    public function insertNews(Request $request){
        $news = $request->input('news');
        $news_stick =$news['checked'] ? $this->getStick():0;
        $status = $this->create(['news_title'=>$news['title'],'news_content'=>$news['content'],'news_date'=>date('Y-m-d H:i:s'),'news_publisher'=>Session::get('user')->user_name,'news_type'=>1,'news_stick'=>$news_stick,'active_type'=>006]);
        return $status;
    }



}