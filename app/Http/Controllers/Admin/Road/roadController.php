<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/3/19
 * Time: 15:25
 */

namespace App\Http\Controllers\Admin\Road;


use App\Http\Controllers\Controller;
use App\Models\Admin\Contact\ContackModel;
use Illuminate\Http\Request;


class roadController extends Controller
{
    public $contect;

    public function __construct(){
        $this->contect = new ContackModel();
    }

    public function getRoad(){
        $road =  $this->contect->getRoad();
        if(sizeof($road) == 1){
            return responseToJson(0,'success',$road);
        }else{
            return responseToJson(1,'error');
        }
    }

    public function updateRoad(Request $request){
        $road = $this->contect->updateRoad($request);
        if($road == 1){
            return responseToJson(0,'success');
        }else{
            return responseToJson(1,'error');
        }
    }

}