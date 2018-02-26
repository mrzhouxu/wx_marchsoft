<?php 


namespace  App\Models\Admin;


use Illuminate\Database\Eloquent\Model;
use DB;

/**
* 
*/
class March extends Model
{    

    protected  $table ='march_sigin';
    protected $fillable = ['id','class', 'name', 'sex','NO','phone','dretion'];
    public  $timestamps =true;
    protected  function  getDateFormat(){
        return  time();
    }

    public  function  asDateTime($val){
        return $val;;
    }

	static function get_peoples(){
		$people =DB::table('march_sigin')->paginate(10);
		return $people;
	}

	static function del_people($NO){
		$res =DB::table('march_sigin')
		    ->where('NO',$NO)
		    ->delete();
		 if ($res) {
		 	return  1;
		 }else{
		 	return 0;
		 }

	}
     /**
     	修改报名信息
     **/
	static function modify_people($data){
		$id=$data->id;
        $NO=$data->NO;
        $cla=$data->class;
        $name=$data->name;
        $sex=$data->sex;
        $phone=$data->phone;
        $dretion=$data->dretion;
    	$res=DB::table('march_sigin')
		->where('id',$id)
		->update(['class'=>$cla,'name'=>$name,'NO'=>$NO,'sex'=>$sex,'phone'=>$phone,'dretion'=>$dretion]);
	  if ($res) {
	  	return 1;
	  }else{
	  	return 0;
	  }
		

	}

	/**
	分页
	**/
	static function change(){
		$people=March::paginate( 10, ['id','class', 'name', 'sex','NO','phone','dretion']);
		
		return $people;
	}


	static function search_people($input){
		$where=$input->where;
		$val=$input->val;
		$people=DB::table('march_sigin')->where($where,$val)->paginate(10);
		if ($people) {
			return $people;
		 }else{
		 	return 0;
		 } 
	}
}
