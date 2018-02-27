<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Models\UserInfo\march_user;
use Illuminate\Http\Request;
class userInfoController extends Controller
{

    private static $user_img = 'http://www.marchsoft.cn/Common/img/photo/photo/m_';

    public function select_finish_user() {
        $page = Input::get('page');
        $number = Input::get('number');

        $user_lec = march_user::get_user_info($page,$number);
        foreach ($user_lec as $user) {
            foreach ($user as $key=>$value) {
//                dd($key);
                if($key == 'avator' && $value != null) {
                    if($value != null) $user->$key = self::$user_img.$value;
                    else continue;
                    
                    // $user->$key = self::$user_img.$value;
                }
                if($key != 'avator' && $value == null) {
                    $user->$key = '暂无';
                }
            }
        }


        return $user_lec ? responseToJson(0,'',$user_lec) : responseToJson(1,'查询失败');
    }

    public function select_user_number() {
        $user_number = march_user::select_user_number();
        return $user_number ? responseToJson(0,'',$user_number) :　responseToJson(1,'插叙失败');

    }

    public function update_user_mesg(Request $request) {
        $file = null;
        $user_info = $request->all();
        // dd($user_info);
        // dd(($user_info['user_sex'] == '男' || $user_info['user_sex'] == '女'));

        if(mb_strlen($user_info['user_name'],'utf-8')<2 || mb_strlen($user_info['user_name'],'utf-8')>4) {
            return responseToJson(1,'姓名格式不正确');
        }else if(mb_strlen($user_info['user_sex'],'utf-8')<1) {
            return responseToJson(1,'请填写学生性别');
        }else if(!($user_info['user_sex'] == '男' || $user_info['user_sex'] == '女')) {
            return responseToJson(1,'请正确填写学生性别');
        }else if(mb_strlen($user_info['class'],'utf-8') >10 || mb_strlen($user_info['class'],'utf-8') <1) {
            return responseToJson(1,'请正确填写学生班级');
        }else if(mb_strlen($user_info['department'],'utf-8')<1 || mb_strlen($user_info['department'],'utf-8')>15) {
            return responseToJson(1,'请正确填写所在院系');
        }else if(mb_strlen($user_info['describe'],'utf-8')<2 || mb_strlen($user_info['describe'],'utf-8')>50) {
            return responseToJson(1,'个人介绍格式错误');
        }

        if(is_string($user_info['avator']) || $user_info['avator'] == null) {
            // dd($user_info['avator']);
            if(strpos($user_info['avator'],self::$user_img)  !== false) {
                $user_info['avator'] = substr($user_info['avator'],strpos($user_info['avator'],'_')+1);
            }else if($user_info['avator'] == null) $user_info['avator'] = null;
            else  return responseToJson(1,'文件非法输入!');
            $file = '';
        }else {
            if($request->hasFile('avator')) {
                $file = $request->file('avator');
            }else {
                return responseToJson(1,'无法获得学生封面照片');
            }
        }
        // dd($user_info);
        foreach ($user_info as $key => $value) {
            
            if($key == 'avator' & $file != '') {
                continue;
            }
            $user_info[$key] = trim($value);
        }
        // dd('aaaa');
        if($file != '') {
            if($file->isValid()) {
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $type = $file->getClientMimeType();     // image/jpeg

                if ($type != "image/jpeg")
                    return responseToJson(1, '讲课封面必须是JPEG格式');
                else if($file->getClientSize() / 1024 /1024 > 2)
                    return responseToJson(1,'讲课封面不能大于2MB');
                $fileName = getFilename('jpg');
                $user_info['avator'] = $fileName;

                $update_boo = march_user::update_user_mesg($user_info);
                return $update_boo ? responseToJson(0,'修改成功') :　responseToJson(1,'修改失败');
                 // dd($update_boo);
            }
        }else {
            $update_boo = march_user::update_user_mesg($user_info);
            return $update_boo ? responseToJson(0,'修改成功') :responseToJson(1,'修改失败');
        }
       
    }

    public function delete_users_info(Request $request) {
        if($request->isMethod('post')) {
            $user_tel_arr = $request->all();
            if(count($user_tel_arr)<1) return responseToJson(1,'未选中需删除的行!');

            $users_avator = march_user::delete_user_msg($user_tel_arr);

            if(count($users_avator)>0) {
                return responseToJson(0,'删除成功');
            }else {
                return responseToJson(1,'删除失败');
            }
        }
    }

    public function new_user_msg(Request $request) {
        $user_info = $request->all();
        

    }
 
    public function getStudents(Request $request){

        $student = march_user::getStudentList($request);
        $lenght = sizeof($student);
//        dd($student);
        if($lenght>0){
            return responseToJson(0,'success',$student);
        }elseif($lenght == 0){
            return responseToJson(2,'success','nothing');
        }else{
            return responseToJson(1,'error','500');
        }
    }

    public function getStudent(Request $request){
        $student = march_user::getStudent($request);
        $lenght = sizeof($student);
        // dd($student);
        if($lenght == 1){
            return responseToJson(0,'success',$student);
        }elseif($lenght == 0){
            return responseToJson(2,'success','nothing');
        }else{
            return responseToJson(1,'error','500');
        }

    }
 
}
