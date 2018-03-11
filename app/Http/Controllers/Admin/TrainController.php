<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use App\Models\Admin\Train;
use Excel;  

/**
* 
*/
class TrainController extends Controller
{
	function get_people(){
		return Response::json(Train::get_peoples());
	}


	function del_people(Request $request,$NO){
		$res=Train::del_people($NO);
		if($res){
			return responseToJson(0, "删除成功");
		}else{
			return responseToJson(1, "删除失败");
	   }
	}


	function change_page(Request $request){
		$res=Train::change();
		if($res){
				return Response::json($res);
		}else{
			return responseToJson(1, "查询失败");	
		}
	}


	function  search_people(Request $request){
     $res=Train::search_people($request);
     if ($res) {
     	return Response::json($res);
     }else{
     	return responseToJson(1, "查询失败");	
     }
	}


	function exopor_excel(Request $request){
	     $res=Train::get_val($request);    
          Excel::create('学生信息',function($excel) use ($res) {
             $excel->sheet('score', function($sheet) use ($res){
             	 $sheet->fromArray($res);

            });
        })->store('xls')->export('xls');
	     }

}