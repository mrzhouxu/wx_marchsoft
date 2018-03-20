<?php

namespace App\Http\Controllers;

use App\Models\Lecture\march_lecture;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
define("_WEBSITE_",'http://www.marchsoft.cn/OA/Common/img/lecture/m_');
class LectureController extends Controller
{


    public function get_all_lecture() {

        $page =  Input::get('page');
        $number = Input::get('number');

        $lec = march_lecture::get_lecture($page,$number);

        return $lec;
    }

    public function get_count_lecture() {
        $count = march_lecture::get_lecture_count();

        return $count;
    }

    public function get_lecture_sort() {
        $sort = march_lecture::get_sort_lecture();

        return $sort;
    }

    public function set_lec_message(Request $request) {
        if($request->isMethod('post')){


            //上传文件事物回滚（未进行！！）

            $lec_arr = $request->all();
            foreach ($lec_arr as $key=>$value) {
                $value = trim($value);
                if($key == 'lecture_img' & strpos($value,_WEBSITE_)  !== false) {
                    $lec_arr[$key] = substr($value,strpos($value,'_')+1);
                }
            }

            //进行后台信息验证验证   (未进行！)

            $bool = march_lecture::set_lec_message($lec_arr);

            if($bool) {
                return responseToJson(0,'修改成功');
            }
            else {
                return responseToJson(1,'修改失败');
            }

        }
    }

    public function delete_lecture() {

        //事物回滚   （未进行！）
        //删除图片和视频


        $lecture_id = Input::get('idmarch_lecture');



        $bool = march_lecture::del_lecture($lecture_id);
        if($bool) {
            return responseToJson(0,'删除成功');
        }
        else {
            return responseToJson(1,'删除失败');
        }
    }

    public function get_lecture_user() {

        $user_arr = march_lecture::get_user_lecture();
        if(!empty($user_arr)) return $user_arr;
        else return responseToJson(1,'查询已知讲课人失败');
    }

    public function new_lecture(Request $request) {
       $video =  $request->file('video');
       $img = $request->file('img');
       $a = $request->all();


       dd($img);

        




    }
}
