<?php

namespace App\Http\Controllers\Wx\algorithm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wx\Algorithm;

class wxAlgorithmController extends Controller
{
    public function get_new_algorithm(){
        $getalgorithm = Algorithm::get_newalgorithm();
        return responseToJson(0, "查询成功",$getalgorithm);
    }

    public function get_all_algorithms(){
    	$allalgorithm=Algorithm::get_allalgorithms();
    	return responseToJson(0, "查询成功",$allalgorithm);
    }

    public function get_detailed_algorithms(Request $request){
    	$id= $request->input('id');
    	$detailedcontent=Algorithm::get_detailedalgorithms($id);
    	return responseToJson(0, "查询成功",$detailedcontent);
    }
}