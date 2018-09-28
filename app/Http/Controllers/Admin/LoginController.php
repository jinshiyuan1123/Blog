<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code.class.php';
class LoginController extends CommonController{

    /**
     * @Desc:后台登录
     * @author:guomin
     * @date:2017-09-28 21:02
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(){
        if($input=Input::all()){
            if($input['vcode']!=$_SESSION['code']){
                echo '验证码错误';
            }else{
                $table=DB::table('blog_user');
                $user=$table->where('user_name',$input['user_name'])->first();
                if($user){
                    if(Crypt::decrypt($user->user_pass)==$input['user_pass']){
                        $data=array();
                        $data['user_id']=$user->user_id;
                        $data['login_count']=$user->login_count+1;
                        $data['last_ip']=$_SERVER["REMOTE_ADDR"];
                        $data['last_login']=date('Y-m-d H:i:s');
                        $table->update($data);
                        session(['user'=>$user]);
                        echo 0;
                    }else{
                        echo '密码错误';
                    }
                }else{
                    echo '用户名错误';
                }
            }
        }else{
            session(['user'=>'']);
            return view('admin.login');
        }

    }

    /**
     * @Desc:生成验证码
     * @author:guomin
     * @date:2017-09-28 22:58
     */

    public function code(){
        $code=new \ValidateCode();
        $code->doimg();
        $_SESSION['code']=$code->getCode();
    }

    /**
     * @Desc:后台退出
     * @author:guomin
     * @date:2017-09-29 22:27
     */
    public function quit(){
        session(['user'=>null]);
        return redirect('admin/login');
    }

}
