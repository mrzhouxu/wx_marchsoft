<?php

namespace App\Models\UserInfo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class march_user extends Model
{
    private static $user = 'march_user';
    private static $user_info = 'march_user_info';


    public static function get_user_info($page = 0, $number = 10)
    {
        $user_sel = DB::table(self::$user)
            ->leftJoin(self::$user_info, self::$user . '.user_phone', '=', self::$user_info . '.user_phone')
            ->select(
                self::$user . '.user_name',
                self::$user . '.user_phone',
                self::$user_info . '.user_sex',
                self::$user_info . '.describe',
                self::$user_info . '.department',
                self::$user_info . '.class',
                self::$user_info . '.avator',
                self::$user_info . '.level'

            )
            ->offset($page * $number)->limit($number)
            ->orderBy(self::$user_info . '.level', 'desc')->get();

        return $user_sel ? $user_sel : false;
    }


    public static function select_user_number()
    {
        $user_number = DB::table(self::$user)->leftJoin(self::$user_info, self::$user . '.user_phone', '=', self::$user_info . '.user_phone')->count();
        return $user_number ? $user_number : false;
    }

    public static function update_user_mesg($user_info)
    {
        // try{
        // dd($user_info);
        $up_boo = DB::table(self::$user)
            ->leftJoin(self::$user_info, self::$user . '.user_phone', '=', self::$user_info . '.user_phone')
            ->where(self::$user . '.user_phone', $user_info['user_phone'])
            ->update([
                self::$user . '.user_phone' => $user_info['user_phone'],
                self::$user . '.user_name' => $user_info['user_name'],
                self::$user_info . '.user_phone' => $user_info['user_phone'],
                self::$user_info . '.user_sex' => $user_info['user_sex'],
                self::$user_info . '.department' => $user_info['department'],
                self::$user_info . '.class' => $user_info['class'],
                self::$user_info . '.avator' => $user_info['avator'],
                self::$user_info . '.describe' => $user_info['describe'],
                self::$user_info . '.level' => $user_info['level']
            ]);
        if ($up_boo) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function add_user_mesg($user_info)
    {
        DB::beginTransaction();
        try {
            $upLoadDataUser = DB::table(self::$user)->insert(
                [
                    self::$user . '.user_phone' => $user_info['user_phone'],
                    self::$user . '.user_name' => $user_info['user_name'],
                    self::$user . '.user_pwd' => md5('123456'),
                    self::$user . '.user_login' => $user_info['user_phone']
                ]);
            $upLoadDataUserInfo = DB::table(self::$user_info)->insert(
                [
                    self::$user_info . '.user_phone' => $user_info['user_phone'],
                    self::$user_info . '.user_sex' => $user_info['user_sex'],
                    self::$user_info . '.department' => $user_info['department'],
                    self::$user_info . '.class' => $user_info['class'],
                    self::$user_info . '.avator' => $user_info['avator'],
                    self::$user_info . '.describe' => $user_info['describe'],
                    self::$user_info . '.level' => $user_info['level']
                ]
            );
            if ($upLoadDataUser == $upLoadDataUserInfo) {
                DB::commit();
            } else {
                DB::rollBack();
                return 0;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
        return 1;
    }

    /**
     * @param $id 通过电话号码获取每个人的头像文件名
     * @return mixed
     */
    public static function getImg($id)
    {
        return $images = DB::table(self::$user_info)->whereIn('user_phone', $id)->limit(sizeof($id))->get(['avator']);
    }

    /**
     * @param $user_tel_arr 所选择的电话号码
     * @return array
     */
    public static function delete_user_msg($user_tel_arr)
    {
        $images = march_user::getImg($user_tel_arr);

        DB::beginTransaction();
        try {
            $del = DB::table(self::$user_info)->whereIn(self::$user_info . '.user_phone', $user_tel_arr)->delete();
            $del_boo = DB::table(self::$user)->whereIn(self::$user . '.user_phone', $user_tel_arr)->delete();

            if($del_boo == $del){
                for ($i = 0; $i < sizeof($images); $i++) {
                    Storage::disk('test')->delete('m_'.$images[$i]->avator);

                }
                DB::commit();
            }else{
                DB::rollBack();
                return 0;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
        return 1;
    }

    private static function select_users_avator($user_tel_arr)
    {
        $users_avator = DB::table(self::$user)->leftJoin(self::$user_info, self::$user . '.user_phone', '=', self::$user_info . '.user_phone')
            ->whereIn(self::$user . '.user_phone', $user_tel_arr)->select('avator')->get();

        return $users_avator;
    }


    public static function getStudentList(Request $request)
    {
        $page = intval($request->input('page'));
        $student = DB::table(self::$user)->leftJoin(self::$user_info, self::$user . '.user_phone', '=', self::$user_info . '.user_phone')->where('user_name', '!=', null)
            ->offset(($page - 1) * 10)
            ->limit(10)
            ->get(['user_name', 'describe', 'avator', 'iduser_info']);
        return $student;
    }

    public static function getStudent(Request $request)
    {
        $id = $request->input('pid');
        $student = DB::table(self::$user)->leftJoin(self::$user_info, self::$user . '.user_phone', '=', self::$user_info . '.user_phone')
            ->where('iduser_info', $id)
            ->first(['user_name', 'describe', 'avator', 'department', 'class', 'march_user.user_phone']);
        return $student;
    }
}
