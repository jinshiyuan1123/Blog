## 一、把本地项目上传到git远程仓库 ##
### 1.初始化项目 ###

	git init

### 2.文件添加到版本库 ###

	git add .

### 3.文件提交到仓库 ###

	git commit -m "文件提交"

### 4.关联远程仓库 ###

	git remote add origin git@github.com:yushi5344/vueJs.git

### 5.获取远程库与本地合并 ###

	git pull --rebase origin master

### 6.把本地库推送到远程 ###

	git push -u origin master


## 二、将项目复制到新环境 ##

### 1.先进行克隆 ###

	git clone git@github.com:yushi5344/vueJs.git

### 2.解决依赖 ###

	composer install

### 3.建立.env文件 ###

	cp .env.example .env

### 4.生成key ###

	php artisan key:generate

### 5.在env文件中设置响应数据库信息 ###

	APP_ENV=local
	APP_KEY=base64:H6RIhyLBY-SOME-KEY-HERE-FkzCvGdS8WOU=
	APP_DEBUG=true
	APP_LOG_LEVEL=debug
	APP_URL=http://localhost
	
	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=my_dbname
	DB_USERNAME=homestead
	DB_PASSWORD=secret

### 6.建立数据库 ###

	php artisan migrate

## 三、可能遇到的问题 ##

### 1.linux上没有安装git  ###

	yum install git 

### 2.linux上没有安装composer ###

1. 下载composer

		curl -sS https://getcomposer.org/installer | php
1. 将composer.phar文件移动到bin目录，全局使用composer命令

		mv composer.phar /usr/local/bin/composer

1. 切换国内源

		composer config -g repo.packagist composer https://packagist.phpcomposer.com

### 3.安装依赖报错 ###

	The Process class relies on proc_open,which is not avaliable on your PHP installation

或者

	proc_get_status() has been disabled for security reasons

解决方法

	修改php.ini 配置文件

### 4.首页一片空白，也不报错 ###

	修改storage以及它下面的文件夹权限
	chmod 777 -R storage

### 5.首页可刷出来，其他页面报404错误 ###

	修改nginx.conf文件
	location / {
	    try_files $uri $uri/ /index.php?$query_string;
	}