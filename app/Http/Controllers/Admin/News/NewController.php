<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2017/11/5
 * Time: 15:32
 */

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use App\Models\Admin\News\NewModel;
use Illuminate\Http\Request;

class NewController extends Controller
{
    public $newModel;

    public function __construct()
    {
        $this->newModel = new NewModel();
    }

    public function getNew()
    {
        $news = $this->newModel->getNews();
//      $this->newModel
    }

    public function getNewItem()
    {
        $item = $this->newModel->getNewsItem();
        return responseToJson(0, 'success', $item);
    }

    public function deleteNews(Request $request)
    {
        $status = $this->newModel->deleteNews($request->input('id'));
        if ($status>0) {
            return responseToJson(0, 'success', 'yes');
        } else {
            return responseToJson(1, 'error', 'no');
        }
    }

    private function judgeNull(Request $request)
    {
        if ($request->input('news')['title'] == '') {
            return 1;
        } elseif ($request->input('news')['content'] == '') {
            return 2;
        } else {
            return  0;
        }
    }

    public function insertNews(Request $request)
    {
        $judge = $this->judgeNull($request);
        if ($judge == 0) {
            $status = $this->newModel->insertNews($request);
            if (sizeof($status) == 1) {
                return responseToJson(0, 'success', 'yes');
            } else {
                return responseToJson(1, 'error', 'no');
            }
        }elseif($judge == 1){
            return responseToJson(2,'error','titleNO');
        }else{
            return responseToJson(3,'error','contentNO');
        }
    }

    public function getOneNew(Request $request)
    {
        $new = $this->newModel->getOneNew($request);
        if (sizeof($new) == 1) {
            return responseToJson(0, 'success', $new);
        } else {
            return responseToJson(1, 'error', 'no');
        }
    }

    public function updateNew(Request $request)
    {
        $this->judgeNull($request);
        $status = $this->newModel->updateNews($request);
        if (sizeof($status) == 1) {
            return responseToJson(0, 'success', 'yes');
        } else {
            return responseToJson(1, 'error', 'no');
        }
    }

    private function killChar($content)
    {
        return mb_substr(preg_replace('# #', '', strip_tags($content)), 0, 45, 'UTF-8');
    }
}
