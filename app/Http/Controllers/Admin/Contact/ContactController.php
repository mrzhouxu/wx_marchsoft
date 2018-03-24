<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2017/12/7
 * Time: 20:26
 */

namespace App\Http\Controllers\Admin\Contact;

use App\Http\Controllers\Controller;
use App\Models\Admin\Contact\ContackModel;
use Illuminate\Http\Request;


class ContactController extends Controller
{
    public $contack;

    public function __construct(){
        $this->contack = new ContackModel();
    }

    public function getContent(){

        $data = $this->contack->getContent();
        return responseToJson(0,'success',$data);
    }

    public function updateContent(Request $request){

        $data = $this->contack->setContent($request);
        if(sizeof($data) == 1){
            return responseToJson(0,'success','');
        }else{
            return responseToJson(1,'error','');
        }
    }


}