<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2017/12/7
 * Time: 20:30
 */

namespace App\Models\Admin\Contact;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ContackModel extends Model
{
    protected $table = 'wx_contact';
    protected $primaryKey = 'idwx_contact';
    public $timestamps = false;
    protected $fillable = ['content'];

    public function getContent(){

        return $this->first(['content']);

    }

    public function setContent(Request $request){

        return $this->where('idwx_contact',1)->update(['content'=>$request->input('content')]);
    }


}