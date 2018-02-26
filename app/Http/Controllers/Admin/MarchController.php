<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use App\Models\Admin\March;

/**
* 
*/
class MarchController extends Controller
{
	
	function get_people(){
	return Response::json(March::get_peoples());
	}
	
	function del_people(Request $request,$NO){
		$res=March::del_people($NO);
		if($res){
			return responseToJson(0, "删除成功");
		}else{
			return responseToJson(1, "删除失败");
	}

}

   /**
   修改信息
   **/
	function modify_people(Request $request){
		if ($request->isMethod('post')) {
			$res=March::modify_people($request);
			if ($res) {
				return responseToJson(0, "修改成功");	
			}else{
				return responseToJson(1, "修改失败");	
			}
		}
	}
     /**
 		分页
     **/
	function change_page(Request $request){
		$res=March::change();
		if($res){
				return Response::json($res);
		}else{
			return responseToJson(1, "查询失败");	
		}
	}
	/**
 	 搜索
	**/
	function  search_people(Request $request){
     $res=March::search_people($request);
     if ($res) {
     	return Response::json($res);
     }else{
     	return responseToJson(1, "查询失败");	
     }
	}



	
}
