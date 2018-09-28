<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Model\Article;
use App\Http\Model\Wechat_user;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WechatController extends Controller
{
    //
    public function __construct()
    {
       // $this->responseMsg();
    }



    public function index(){
        if(isset($_GET["signature"])&&isset($_GET["timestamp"])&&isset($_GET["nonce"])&&isset($_GET["echostr"])){
            $signature = $_GET["signature"];//从用户端获取签名赋予变量signature
            $timestamp = $_GET["timestamp"];//从用户端获取时间戳赋予变量timestamp
            $nonce = $_GET["nonce"];    //从用户端获取随机数赋予变量nonce

            $token =env('WECHAT_TOKEN');//将常量token赋予变量token
            $tmpArr = array($token, $timestamp, $nonce);//简历数组变量tmpArr
            sort($tmpArr, SORT_STRING);//新建排序
            $tmpStr = implode( $tmpArr );//字典排序
            $tmpStr = sha1( $tmpStr );//shal加密
            //tmpStr与signature值相同，返回真，否则返回假
            if( $tmpStr == $signature ){
                echo $_GET["echostr"];
            }else{
                return false;
            }
        }
    }

    public function store()
    {
        //get post data, May be due to the different environments
        $postStr = file_get_contents('php://input');//将用户端放松的数据保存到变量postStr中，由于微信端发送的都是xml，使用postStr无法解析，故使用$GLOBALS["HTTP_RAW_POST_DATA"]获取
        if (!empty($postStr)){

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);//将postStr变量进行解析并赋予变量postObj。simplexml_load_string（）函数是php中一个解析XML的函数，SimpleXMLElement为新对象的类，LIBXML_NOCDATA表示将CDATA设置为文本节点，CDATA标签中的文本XML不进行解析
            $RX_TYPE = trim($postObj->MsgType);
            switch($RX_TYPE){
                case 'text':
                    $result=$this->responseText($postObj);
                    break;
                case 'image':
                    $result=$this->responeImage($postObj);
                    break;
                case 'voice':
                    $result=$this->responseVoice($postObj);
                    break;
                case 'video':
                    $result=$this->responseVideo($postObj);
                    break;
                case 'location':
                    $result=$this->responseLocation($postObj);
                    break;
                case 'link':
                    $result=$this->responseLink($postObj);
                    break;
                case 'event':
                    $result=$this->responseEvent($postObj);
                    break;
                default:
                    $result="未知消息类型".$RX_TYPE;
                    break;
            }
            echo $result;
        }else {
            echo "aaa";//回复为空，无意义，调试用
            exit;
        }
    }
    public function create(){
        $access=$this->getAccess();
        $data=<<<aaa
            {
                "button":[
                    {
                        "name":"测试1",
                        "sub_button":[
                            {
                            "type":"click",
                            "name":"子菜单1",
                            "key":"name1"
                            },
                            {
                            "type":"click",
                            "name":"子菜单2",
                            "key":"name2"
                            }
                        ]
                    },
                    {
                    "type":"view",
                    "name":"aboutme",
                    "url":"http://47.95.218.48/"
                    },
                    {
                    "type":"view",
                    "name":"今日歌曲",
                    "url":"http://music.163.com/#/song?id=276146"
                    }
                ]
            }
aaa;
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access;
        $result=$this->curl($url,$data);
        return $result;
    }


    /**
     * @Desc:删除菜单
     * @author:guomin
     * @date:2017-11-01 23:17
     */
    public function show($id){
        $access=$this->getAccess();
        $url="https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$access;
        $result=$this->curl($url);
        print_r($result);
    }

    private function responseText($obj){
        if($obj->Content==trim('【收到不支持的消息类型，暂无法显示】')){
            $contentStr="您发送的是自定义表情。";
        }else{
            $contentStr= $this->getTulLing($obj->Content,$obj->FromUserName);
        }
        $result=$this->transmitText($obj,$contentStr);
        return $result;
    }

    private function getTulLing($text,$openId){
        $url="http://openapi.tuling123.com/openapi/api/v2";
        $apiKey=env('TULING_APIKEY');
        $data=<<<data
            {
                "reqType":0,
                "perception": {
                    "inputText": {
                        "text": "$text"
                    }
                },
                "userInfo": {
                    "apiKey": "$apiKey",
                    "userId": "$openId"
                }
            }
data;
        $result=$this->curl($url,$data);
        $result=json_decode($result,true);
        return$result['results'][0]['values']['text'];
    }
    private function responeImage($obj){
        $contentStr="您发送的是图片，地址为：".$obj->PicUrl;
        $result=$this->transmitText($obj,$contentStr);
        return $result;
    }

    private function responseVoice($obj){
        $contentStr="您发送的是语音，MdiaId为：".$obj->MediaId;
        $result=$this->transmitText($obj,$contentStr);
        return $result;
    }
    private function responseVideo($obj){
        $contentStr="您发送的是视频，MediaId为：".$obj->MediaId;
        $result=$this->transmitText($obj,$contentStr);
        return $result;
    }

    private function responseLocation($obj){
        $contentStr="您发送的是位置，经度为：".$obj->Location_Y.",维度为：".$obj->Location_X.",位置为：".$obj->Label.",缩放级别为：".$obj->Scale;
        $result=$this->transmitText($obj,$contentStr);
        return $result;
    }

    private function responseLink($obj){
        $contentStr="您发送的是超链接，标题位：".$obj->Title."，内容为：".$obj->Description."，链接地址为：".$obj->Url;
        $result=$this->transmitText($obj,$contentStr);
        return $result;
    }

    private function responseEvent($obj){
        if($obj->Event=='subscribe'){
            $contentStr='';
            $user=Wechat_user::where('openId',$obj->FromUserName)->first();
            if($user){
                $contentStr="欢迎回来";
            }else{
                $contentStr="感谢关注";
                $wechat_user=[];
                $wechat_user=$this->getInfo($obj->FromUserName);
                if($wechat_user){
                    $wechat_user['openId']=$obj->FromUserName;
                    Wechat_user::create($wechat_user);
                } else{
                    Wechat_user::create(['openId'=>$obj->FromUserName]);
                }
            }
            $result=$this->transmitText($obj,$contentStr);
            return $result;
        }elseif($obj->Event=='CLICK'){
            $article=Article::where('art_pid',1)->orderBy('art_id','desc')->take(10)->get();
            $name1=array();
            $name2=array();
            foreach($article as $key=>$v){
                $name1[]=$v['art_title'];
                $name2[]=$v['art_tag'];
            }
            $b=array_rand($name1);
            if($obj->EventKey=='name1'){
                $str="您点击了菜单1,";
                $str .="这个菜单可以随机显示文章标题：".$name1[$b];
            }elseif($obj->EventKey=='name2'){
                $str="您点击了菜单2,";
                $str .="这个菜单可以随机显示文章标签：".$name2[$b];
            }
            $result=$this->transmitText($obj,$str);
            return $result;
        }

    }

    private function transmitMusic($obj, $content)
    {
        $fromUsername = $obj->FromUserName;//将微信用户端的用户名赋予变量FromUserName
        $toUsername = $obj->ToUserName;//将你的微信公众账号ID赋予变量ToUserName
        //$keyword = trim($obj->Content);//将用户微信发来的文本内容去掉空格后赋予变量keyword
        $time = time();//将系统时间赋予变量time
        //构建XML格式的文本赋予变量textTpl，注意XML格式为微信内容固定格式，详见文档
        $textTpl = "<xml>
                        <ToUserName>< ![CDATA[%s] ]></ToUserName>
                        <FromUserName>< ![CDATA[%s] ]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType>< ![CDATA[music] ]></MsgType>
                        <Music>
                            <Title>< ![CDATA[%s] ]></Title>
                            <Description>< ![CDATA[%s] ]></Description>
                            <MusicUrl>< ![CDATA[%s] ]></MusicUrl>
                            <HQMusicUrl>< ![CDATA[%s] ]></HQMusicUrl>
                            <ThumbMediaId>< ![CDATA[%s] ]></ThumbMediaId>
                        </Music>
                    </xml>";
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, '亲密爱人','测试','http://music.163.com/#/song?id=276146','http://music.163.com/#/song?id=276146','');//将XML格式中的变量分别赋值。注意sprintf函数
        return $resultStr;//输出回复信息，即发送微信
    }
    private function transmitText($obj,$content){
        $fromUsername = $obj->FromUserName;//将微信用户端的用户名赋予变量FromUserName
        $toUsername = $obj->ToUserName;//将你的微信公众账号ID赋予变量ToUserName
        //$keyword = trim($obj->Content);//将用户微信发来的文本内容去掉空格后赋予变量keyword
        $time = time();//将系统时间赋予变量time
        //构建XML格式的文本赋予变量textTpl，注意XML格式为微信内容固定格式，详见文档
        $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";
        $msgType = "text";//回复文本信息类型为text型，变量类型为msgType
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $content);//将XML格式中的变量分别赋值。注意sprintf函数
        return $resultStr;//输出回复信息，即发送微信
    }

    /**
     * @Desc:
     * @author:guomin
     * @date:
     * @param $url
     * @param array $fields
     * @return string
     */
    private function curl($url,$fields=[]){
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        if($fields){
            curl_setopt($ch,CURLOPT_TIMEOUT,30);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
        }
        if(curl_exec($ch)){
            $data=curl_multi_getcontent($ch);
        }
        curl_close($ch);
        return $data;
    }

    /**
     * @Desc:
     * @author:guomin
     * @date:
     * @return bool
     */
    private function getAccess(){
        if(Cache::has(env('APPID'))){
            $access=Cache::get(env('APPID'));
        }else{
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('APPID')."&secret=".env('APPSECRET');
            $data=$this->curl($url);
            $data=json_decode($data,true);
            if(isset($data['errcode'])){
                return false;
            }
            Cache::put(env('APPID'),$data['access_token'],$data['expires_in']/60);
            $access=$data['access_token'];
        }
        return $access;
    }

    public function getUserInfo(){
        $user=Wechat_user::all('openId');
        $a=[];
        $user=$user->toArray();
        foreach($user as $key=>$value){
            $result=$this->getInfo($value['openId']);
            if($result){
               Wechat_user::where('openId',$value['openId'])->update($result);
            }
        }
    }

    /**
     * @Desc:获取微信素材列表
     * @author:guomin
     * @date:2018-04-12 21:45
     */
    public function material(){
        $access=$this->getAccess();
        $data=<<<aaa
            {
                "type":news,
                "offset":0,
                "count":2
            }
aaa;
        $url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$access;
        $result=$this->curl($url,$data);
        dd($result);
        return $result;


    }
    private function getInfo($openId){
        $access=$this->getAccess();
        $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access."&openid=".$openId."&lang=zh_CN";
        $result=$this->curl($url);
        $data=json_decode($result,true);
        if(isset($data['errcode'])){
            return false;
        }else{
            $res=[];
            $res['nickname']=$data['nickname'];
            $res['sex']=$data['sex'];
            $res['language']=$data['language'];
            $res['city']=$data['city'];
            $res['province']=$data['province'];
            $res['country']=$data['country'];
            $res['headimgurl']=$data['headimgurl'];
            $res['subscribe_time']=$data['subscribe_time'];
            return $res;
        }
    }
}
