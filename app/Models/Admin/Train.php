<?php

namespace  App\Models\Admin;


use Illuminate\Database\Eloquent\Model;
use DB;


/**
*
*/
class Train extends Model
{
	protected  $table ='march_train';
    protected $fillable = ['id','class', 'name', 'sex','NO','phone','dretion','cost'];
    public  $timestamps =true;
    protected  function  getDateFormat(){
        return  time();
    }

    public  function  asDateTime($val){
        return $val;;
    }

	public static function get_peoples(){
		$people =Train::paginate(10);
		return $people;
	}
	static  function del_people($NO){
		$res=Train::where('NO',$NO)->delete();
		 if ($res) {
		 	return  1;
		 }else{
		 	return 0;
		 }
	}

	static function change(){
		$people=Train::paginate( 10, ['id','class', 'name', 'sex','NO','phone','dretion']);
		
		return $people;
	}

	static function search_people($input){
		$where=$input->where;
		$val=$input->val;
		$people=Train::where($where,$val)->paginate(10);
		if ($people) {
			return $people;
		 }else{
		 	return 0;
		 } 
	}

	static function get_val($val){
		$where=$val->where;
		$val=$val->val;
		// $people=Train::where($where,$val)->get();
		$people=Train::get();
		return $people;

	}
	
}