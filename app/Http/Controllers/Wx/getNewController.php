<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/1/21
 * Time: 16:54
 */

namespace App\Http\Controllers\Wx;


use App\Http\Controllers\Controller;
use App\Models\Admin\News\NewModel;
use Illuminate\Http\Request;

class getNewController extends Controller
{
    public $newModel;

    public function __construct()
    {
        $this->newModel = new NewModel();
    }

    public function getNews_show(){
        $news = $this->newModel->getNewsItem_show();
        $lenght = sizeof($news);
        if($lenght == 0){
            return responseToJson(2,'success','nothing');

        }else if($lenght >0){
            return responseToJson(0, 'success', $news);
        }else{
            return responseToJson(0,'error','error');
        }
    }

    public function getNewsTime_show(Request $request){
        $news = $this->newModel->getNewsTimeItem_show($request);
        $lenght = sizeof($news);

        if($lenght == 0){
            return responseToJson(2,'success',"nothing");
        }elseif($lenght>0){
            return responseToJson(0, 'success', $news);
        }
    }

    public function getNew_show(Request $request){
        $new = $this->newModel->getNew_show($request);
        if(sizeof($new) == 1){
            return responseToJson(0, 'success', $new);
        }else{
            responseToJson(1, 'error', 'something was worng');
        }
    }



}