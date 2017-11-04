<?php

namespace App\Http\Controllers\Wx;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\Wx\Index;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){}

    public function test(){
        return Template::test();
    }
    
}