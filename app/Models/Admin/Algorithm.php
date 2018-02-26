<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Algorithm extends Model
{
    public static function count_algorithms(){
        return DB::table('daypractice')->count();

    }

    public static function select_algorithms($first,$tail){
        $algorithmslist = DB::table('daypractice')->orderBy('time', 'desc')->offset($first)->limit($tail)->get();
        return $algorithmslist;
    }

    public static function delete_algorithms($id){
    	return DB::table('daypractice')->where('id', $id)->delete();
    }

    public static function add_algorithms($number,$title,$keyword,$subject,$answer){
    	return DB::table('daypractice')->insert(
            ['number' => $number, 'title' => $title, 'type' => $keyword, 'content' => $subject, 'answer' => $answer]
        );
    }

    public static function max_number(){
        return DB::table('daypractice')->select('number')->max('number');
    }

    public static function select_single_information($id){
        return DB::table('daypractice')->select('title','type','content','answer')->where('id',$id)->get();
    }

    public static function update_algorithms($id,$title,$keyword,$subject,$answer){
       return DB::table('daypractice')
        ->where('id', $id)
        ->update(['title' => $title,'type' => $keyword,'content' => $subject,'answer' => $answer]);
    }

}