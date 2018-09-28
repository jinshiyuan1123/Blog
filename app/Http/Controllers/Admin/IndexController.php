<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController{

    /**
     * @Desc:后台首页
     * @author:guomin
     * @date:2017-09-29 22:43
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

       return view('admin.index')->with('Info',\App\Http\Model\User::find(session('user')->user_id));
    }

    /**
     * @Desc:修改密码
     * @author:guomin
     * @date:2017-10-07 15:12
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pass(){
        if($input=Input::all()){
            $rules=[
                'oldpass'=>'required',
                'password'=>'required|between:6,20|confirmed',
            ];
            $messages=[
                'oldpass.required'=>'旧密码不能为空',
                'password.required'=>'新密码不能为空',
                'password.between'=>'新密码在6-20位之间',
                'password.confirmed'=>'新密码和确认密码不一致',
            ];
            $validator=Validator::make($input,$rules,$messages);
            if($validator->passes()){
                $user=\App\Http\Model\User::find(session('user')->user_id);
                $password=Crypt::decrypt($user->user_pass);
                if($password==$input['oldpass']){
                    $user->user_pass=Crypt::encrypt($input['password']);
                    echo $user->update();
                }else{
                    echo 0;
                }
            }else{
                $errors=$validator->errors()->all();
                echo json_encode($errors);
            }
        }else{
            return view('admin.pass');
        }
    }
    public function test(){
          $pass=DB::table('blog_user')->where('user_name','admin')->first();
           $_pass= $pass->user_pass;
       // $_pass=Crypt::decrypt($pass);
         echo $_pass;
    }
}
