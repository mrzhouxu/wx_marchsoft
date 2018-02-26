<?php

namespace App\Http\Controllers\Admin\algorithm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\Models\Admin\Algorithm;

class algorithmController extends Controller
{

    public function get_algorithm(Request $request){
        $first = $request->input('first');
        $tail = $request->input('tail');
        $alogrithmnumber = Algorithm::count_algorithms();
        $algorithmsall = Algorithm::select_algorithms($first,$tail);
          return responseToJson(0, "添加成功",array('alogrithmnumber'=>$alogrithmnumber,'algorithmsall'=>$algorithmsall));
    }

    public function add_algorithm(Request $request){
      $title = $request->input('title');
      $keyword = $request->input('keyword');
      $subject = $request->input('subject');
      $answer = $request->input('answer');

      if($keyword=="")
        $keyword="无";

      if($title==""){
        return responseToJson(2, "标题不能为空");
      }else if($subject==""){
        return responseToJson(4, "题目不能为空");
      }else if($answer==""){
        return responseToJson(5, "答案代码不能为空");
      }else{
        $number=Algorithm::max_number()+1;
        $a=Algorithm::add_algorithms($number,$title,$keyword,$subject,$answer);
        if($a==1)
          return responseToJson(0, "添加成功");
        else
          return responseToJson(1, "添加失败");
      }
    }

    public function delete_algorithm($id){
    		return responseToJson(0, "删除注释掉了");


    }

    public function select_algorithm($id){
        $information=Algorithm::select_single_information($id);
        $information[0]->answer=htmlspecialchars($information[0]->answer);
        if($information)
          return responseToJson(1, "请求成功",$information);
        else
          return responseToJson(0, "请求失败");
    }

    public function update_algorithm(Request $request){
      $id=$request->input('id');
      $title = $request->input('title');
      $keyword = $request->input('keyword');
      $subject = $request->input('subject');
      $answer = $request->input('answer');

      if($keyword=="")
        $keyword="无";

      if($title==""){
        return responseToJson(2, "标题不能为空");
      }else if($subject==""){
        return responseToJson(4, "题目不能为空");
      }else if($answer==""){
        return responseToJson(5, "答案代码不能为空");
      }else{
         $information=Algorithm::update_algorithms($id,$title,$keyword,$subject,$answer);
        if($information==1)
          return responseToJson(0, "修改成功");
        else
          return responseToJson(1, "修改失败".$information.$id);
      }
    }

}