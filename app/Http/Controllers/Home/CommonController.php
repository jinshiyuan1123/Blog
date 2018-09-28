<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct(){
        $nav= Category::orderBy('cate_order','asc')->get();
       View::share('nav',$nav);
    }
}
