<?php
 
 //1.建立连接
        $connect=mysqli_connect('localhost','root','w134789','test','3306');
    //2.定义sql语句
    	$data = $_GET;
    	$datatime = time();
    	// var_dump($data);die;
        $sql="insert into   emlog_blog(title,date,mail,content,datatime) values('{$data['username']}','{$data['usertheme']}','{$data['usermail']}','{$data['content']}','{$datatime}')";

        mysqli_query($connect,'set names utf8');
    //3.发送SQL语句
        $result=mysqli_query($connect,$sql);
        $arr=array();//定义空数组
        while($row =mysqli_fetch_array($result)){
            //var_dump($row);
                //array_push(要存入的数组，要存的值)
            array_push($arr,$row);
        }
      echo"<script>alert('留言成功！');history.go(-1);</script>"; 
    //4.关闭连接
       mysqli_close($connect);