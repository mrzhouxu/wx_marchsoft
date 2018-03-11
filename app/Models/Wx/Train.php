<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;
use DB;

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
    
    static public function set_message($data){
    	$name       = trim($data->name);
        $grade      = trim($data->grade);
        $sex      = trim($data->sex);
        $student_id = trim($data->student_id);
        $phone_num  = trim($data->phone_num);
        $radio      = trim($data->radio);
         $bool = Train::insert([
         	'class' => $grade,
            'name' => $name,
            'sex' => $sex,
            'NO' => $student_id,
            'phone' => $phone_num,
            'dretion' => $radio,
            // 'create_time'=> time(),
        ]);
         if ($bool) {
           	return true;
         }else {
         	return false;
         }


    }
}