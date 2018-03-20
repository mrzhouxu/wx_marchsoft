<?php

namespace App\Http\Controllers\Wx;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wx\Train;
use DB;
class TrainController extends Controller
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
        if( strlen($name) == 0 || strlen($grade) == 0 || strlen($student_id) == 0 || strlen($phone_num) == 0){
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
        }else{
          $res=Train::set_message($request);
        }
         
       
        if ( $res ){
            return responseToJson( 0,'报名成功');
        }else{
            return responseToJson( 1, '报名失败，请重新报名');
        }
       
    }

    public function search(Request $request){
        $student_id = trim($request->student_id);

        if(strlen($student_id) == 0 ){
            return json_encode(['code' => 1, 'msg' => '请重新填写学号']);
        }
        $count = DB::table("march_sigin")->where('NO',$student_id)->count();
        if($count){
            $student = DB::table("march_sigin")->where('NO',$student_id)->first();
            return json_encode([
                'code' => 0,
                'msg' => [
                    'name'          => $student->name,
                    'class'         => $student->grade,
                    'phone'     => $student->phone_num,
                    'dretion'         => $student->radio,
                    'create_time'   => $student->create_time,
                ]
            ]);
        }
        return json_encode(['code' => 1, 'msg' => '未报名']);
    }
    
    public function reset(Request $request){
        $name       = trim($request->name);
        $grade      = trim($request->grade);
        $student_id = trim($request->student_id);
        $phone_num  = trim($request->phone_num);
        $radio      = trim($request->radio);

        if( strlen($name) == 0 ||  strlen($grade) == 0 || strlen($student_id) == 0 || strlen($phone_num) == 0){
            return json_encode(['code' => 1, 'msg' => '请将数据填写完整']);
        }
        $count = DB::table("student")->where('student_id',$student_id)->count();
        $count2 = DB::table("student")->where('student_id','!=',$student_id)
                                    ->where('phone_num',$phone_num)->count();
        if($count == 0){
            return json_encode(['code' => 1, 'msg' => '未报名']);
        }else if($count2 != 0){
            return json_encode(['code' => 1, 'msg' => '电话号码已被占用']);
        }
        DB::table("student")
            ->where('student_id',$student_id)
            ->update([
                'name'          => $name,
                'grade'         => $grade,
                'phone_num'     => $phone_num,
                'radio'         => $radio
            ]);
        return json_encode(['code' => 0, 'msg' => '修改成功']);
    }
    
    
    // public function train(Request $request) {
    //     $name = trim($request->name);
    //     $grade = trim($request->grade);
    //     $student_id = trim($request->student_id);
    // }
}
