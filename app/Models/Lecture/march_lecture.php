<?php

namespace App\Models\Lecture;


use Illuminate\Database\Eloquent\Model;
use DB;

class march_lecture extends Model
{

    private static $model_name = 'march_lecture';
    private static $lec_img_prefix = 'http://www.marchsoft.cn/OA/Common/img/lecture/m_';

    public static function get_lecture($page=0,$number=5) {

        $lec = DB::table(self::$model_name)
//            ->join('march_sort','march_lecture.lecture_sort','=','march_sort.idmarch_sort')
            ->orderBy('lecture_date','desc')
            ->offset($page*$number)
            ->limit($number)
            ->get()->map(function ($value) {
                $value->lecture_img = self::$lec_img_prefix.$value->lecture_img;
                return $value;
            });
//        dd($lec);

        return responseToJson(0,'',$lec);
    }

    public static function get_lecture_count() {
        $count = DB::table(self::$model_name)->count();

        return  responseToJson(0,'',$count);
    }

    public static function get_sort_lecture() {
        $sort = DB::table('march_sort')->get();

        return responseToJson(0,'',$sort);
    }

    public static function set_lec_message($lec_arr) {
        $boo = DB::table(self::$model_name)
            ->where('idmarch_lecture',$lec_arr['idmarch_lecture'])
            ->update([
                'lecture_user'    => $lec_arr['lecture_user'],
                'lecture_date'    => $lec_arr['lecture_date'],
                'lecture_content' => $lec_arr['lecture_content'],
                'lecture_sort'    => $lec_arr['lecture_sort'],
                'lecture_img'     => $lec_arr['lecture_img'],
                'lecture_theme'   => $lec_arr['lecture_theme']
            ]);

        if($boo) return true;
        else return false;
    }

    public static function del_lecture($del_lec_id) {
//        static $boo=null;
        $boo = DB::table(self::$model_name)->where('idmarch_lecture',$del_lec_id)->get();
//        if(!is_array($del_lec_id))


        if($boo) return true;
        else return false;
    }

    public static function get_user_lecture() {

        $user_arr = DB::table(self::$model_name)->select('lecture_user')->distinct()->get();
        return responseToJson(0,'',$user_arr);
    }

    public static function lecture_new() {

    }
}
