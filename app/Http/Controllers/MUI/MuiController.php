<?php

namespace App\Http\Controllers\MUI;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class MuiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data=[
            'status'=>1,
            'msg'=>'index方法请求成功',
            'url'=>URL::full(),
            'method'=>$request->method()
        ];
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data=[
            'status'=>1,
            'msg'=>'GET请求成功'
        ];
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data=[
            'status'=>1,
            'msg'=>'POST方式请求成功',
            'url'=>URL::full(),
            'method'=>$request->method()
        ];
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data=[
            'status'=>1,
            'msg'=>'GET请求成功'
        ];
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data=[
            'status'=>1,
            'msg'=>'PUT方式请求成功',
            'url'=>URL::full(),
            'method'=>$request->method()
        ];
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //
        $data=[
            'status'=>1,
            'msg'=>'DELETE请求成功',
            'url'=>URL::full(),
            'method'=>$request->method()
        ];
        return $data;
    }
}
