<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;
use DB;

class Algorithm extends Model
{
    static public function get_newalgorithm(){
    	return DB::table('daypractice')
    			->select('content', 'answer','time')
    			->orderBy('number','desc')
    			->orderBy('time','desc')
    			->limit(1)->get();
    }

    static public function get_allalgorithms(){
    	return DB::table('daypractice')->select('id','title','type','time')->orderBy('time', 'desc')->get();
    }

    static public function get_detailedalgorithms($id){
    	return DB::table('daypractice')->select('title','content', 'answer','time')
    			->where('id',$id)
    			->get();
    }
}


