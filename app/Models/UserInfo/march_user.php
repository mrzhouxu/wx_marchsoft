<?php
namespace App\Models\UserInfo;


use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;
use Illuminate\Http\Request;

class march_user extends Model
{

    private static $user = 'march_user';
    private static $user_info = 'march_user_info';
    


    public static function get_user_info($page = 0,$number = 10) {
        $user_sel = DB::table(self::$user)
            ->leftJoin(self::$user_info,self::$user.'.user_phone','=',self::$user_info.'.user_phone')

            ->select(
                self::$user.'.user_name',
                self::$user.'.user_phone',
                self::$user_info.'.user_sex',
                self::$user_info.'.describe',
                self::$user_info.'.department',
                self::$user_info.'.class',
                self::$user_info.'.avator',
                self::$user_info.'.level'

            )
            ->offset($page*$number)->limit($number)
            ->orderBy(self::$user_info.'.level','desc')->get();

        return $user_sel ? $user_sel :false;
    }


    public static function select_user_number() {
        $user_number = DB::table(self::$user)->leftJoin(self::$user_info,self::$user.'.user_phone','=',self::$user_info.'.user_phone')->count();
        return $user_number ? $user_number : false;
    }

    public static function update_user_mesg($user_info) {
        // try{
            // dd($user_info);
            $up_boo = DB::table(self::$user)
            ->leftJoin(self::$user_info,self::$user.'.user_phone','=',self::$user_info.'.user_phone')
            ->where(self::$user.'.user_phone',$user_info['user_phone'])
            ->update([
                self::$user.'.user_phone' => $user_info['user_phone'],
                self::$user_info.'.user_phone' => $user_info['user_phone'],
                self::$user.'.user_name' => $user_info['user_name'],
                self::$user_info.'.user_sex' => $user_info['user_sex'],
                self::$user_info.'.department' => $user_info['department'],
                self::$user_info.'.class' => $user_info['class'],
                self::$user_info.'.avator' => $user_info['avator'],
                self::$user_info.'.describe' => $user_info['describe'],
                self::$user_info.'.level' => $user_info['level']
            ]);
            if($up_boo) {
                return 1;
            }else {
                return 0;
            }
    }

    public static function delete_user_msg($user_tel_arr) {

        $users_avator = self::select_users_avator($user_tel_arr);

        $del_boo = DB::table(self::$user)->leftJoin(self::$user_info,self::$user.'.user_phone','=',self::$user_info.'.user_phone')
        ->whereIn(self::$user.'.user_phone',$user_tel_arr)
        ->get();
        // ->delete();

        if($del_boo) return $users_avator;
        else return [];
    }

    private static function select_users_avator($user_tel_arr) {
        $users_avator = DB::table(self::$user)->leftJoin(self::$user_info,self::$user.'.user_phone','=',self::$user_info.'.user_phone')
        ->whereIn(self::$user.'.user_phone',$user_tel_arr)->select('avator')->get();

        return $users_avator;
    }


    public static function getStudentList(Request $request){

        $page = intval($request->input('page'));
        $student = DB::table(self::$user)->leftJoin(self::$user_info,self::$user.'.user_phone','=',self::$user_info.'.user_phone')->where('user_name','!=',null)
            ->offset(($page-1)*10)
            ->limit(10)
            ->get(['user_name','describe','avator','iduser_info']);
        return $student;
    }

    public static function getStudent(Request $request){
        
        $id = $request->input('pid');
        $student = DB::table(self::$user)->leftJoin(self::$user_info,self::$user.'.user_phone','=',self::$user_info.'.user_phone')
        ->where('iduser_info',$id)
        ->first(['user_name','describe','avator','department','class','march_user.user_phone']);
        return $student;
    }

}