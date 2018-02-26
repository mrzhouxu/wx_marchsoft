<?php

namespace App\Http\Controllers\Wx;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class WxSignUpController extends Controller
{
    public function sign(Request $request){

        // $input = $request->all();
        // $phone = $input['phone_num'];

        // // 验证码
        // $sms = new SmsController();
        // $sms->sendSms($phone);
        $name       = trim($request->name);
        $grade      = trim($request->grade);
        $sex      = trim($request->sex);
        $student_id = trim($request->student_id);
        $phone_num  = trim($request->phone_num);
        $radio      = trim($request->radio);

        if( strlen($name) == 0 || strlen($grade) == 0 || strlen($sex) == 0 || strlen($student_id) == 0 || strlen($phone_num) == 0){
            return json_encode(['code' => 1, 'msg' => '请将数据填写完整']);
        }

        $count = DB::table("march_sigin")
            ->where('NO',$student_id)
            ->count();
        $count2 = DB::table("march_sigin")
            ->where('phone',$phone_num)
            ->count();
        if($count){
            return json_encode(['code' => 1, 'msg' => '已报名，请不要重复报名']);
        }else if($count2){
            return json_encode(['code' => 1, 'msg' => '电话号码已被占用']);
        }

        $id = DB::table('march_sigin')->insertGetId([
            'name'          => $name,
            'class'         => $grade,
            'sex'         => $sex,
            'NO'    => $student_id,
            'phone'     => $phone_num,
            'dretion'         => $radio,
            'create_time'   => time(),
        ]);
        if ( $id ){
            return json_encode(['code' => 0, 'msg' => '报名成功']);
        }
        return json_encode(['code' => 1, 'msg' => '报名失败，请重新报名']);
    }

    public function search(Request $request){
        $student_id = trim($request->student_id);

        if(strlen($student_id) == 0 ){
            return json_encode(['code' => 1, 'msg' => '请重新填写学号']);
        }
        $count = DB::table("march_sigin")->where('NO',$student_id)->count();
        if($count == 0){
            return json_encode(['code' => 1, 'msg' => '未报名']);
        }                         
        if($count){
            $student = DB::table("march_sigin")->where('NO',$student_id)->first();
            return json_encode([
                'code' => 0,
                'msg' => [
                    'name'          => $student->name,
                    'class'         => $student->class,
                    'sex'           => $student->sex,
                    'student_id'           => $student->NO,
                    'phone'     => $student->phone,
                    'dretion'         => $student->dretion,
                    'create_time'   => date("Y-m-d H:i",$student->create_time),
                ]
            ]);
        }
        return json_encode(['code' => 1, 'msg' => '未报名']);
    }
    
    public function reset(Request $request){
        $name       = trim($request->name);
        $grade      = trim($request->grade);
        $sex      = trim($request->sex);
        $student_id = trim($request->student_id);
        $phone_num  = trim($request->phone_num);
        $radio      = trim($request->radio);

        if( strlen($name) == 0 ||  strlen($grade) == 0 || strlen($sex) == 0 || strlen($student_id) == 0 || strlen($phone_num) == 0){
            return json_encode(['code' => 1, 'msg' => '请将数据填写完整']);
        }
        $count = DB::table("march_sigin")->where('NO',$student_id)->count();
        $count2 = DB::table("march_sigin")->where('NO','!=',$student_id)
                                    ->where('phone',$phone_num)->count();
        if($count == 0){
            return json_encode(['code' => 1, 'msg' => '未报名']);
        }else if($count2 != 0){
            return json_encode(['code' => 1, 'msg' => '电话号码已被占用']);
        }
        DB::table("march_sigin")
            ->where('NO',$student_id)
            ->update([
                'name'          => $name,
                'class'         => $grade,
                'sex'         => $sex,
                'phone'     => $phone_num,
                'dretion'         => $radio,
                'create_time'   => time(),
            ]);
        return json_encode(['code' => 0, 'msg' => '修改成功']);
    }
    
    
    // public function train(Request $request) {
    //     $name = trim($request->name);
    //     $grade = trim($request->grade);
    //     $student_id = trim($request->student_id);
    // }
}
