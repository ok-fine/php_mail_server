# php_mail_server
php、socket、mail server、smtp、pop3  
 
## English
This is a mail system depends on socket programming, it will allocate a 'user server' (socket interface) for each user when login, and create a temp 'user client' (socket interface) any time chat with other's 'user server'.

### How to config
change the 'Config.txt' as follow  
![Image text](https://raw.githubusercontent.com/ok-fine/php_mail_server/master/img-folder/1.png)  
 
### Runtime
1. MacOS、Linux System (Windows unsupport 'pcntl_fork()')
2. Idea
3. Php，Aphache
4. php and socket components

### How to run
1. run the mail server and background it in load：“php_mail_server / MailServer / MailServer.php” 
![Image text](https://raw.githubusercontent.com/ok-fine/php_mail_server/master/img-folder/2.png)
2. run the login page:“php_mail_server / Controller / login.php” and it will start an login web page.
3. Notice：if you want to send a mail to user1, you must login user1 first
4. or it will send the mail every 30 minuts (but this funtion still wrong, so the mail will disappear while user1 haven't login).
 
 
## 中文版
本系统是自己用socket编写的邮件服务器，登陆时为每一个用户分配一个user server（socket接口），在用户需要执行操作的时候，临时创建一个user client（MUA）socket接口来与user server进行会话。

端口设置：  
[50000 - 59999] 用户管理等，同时也是接收邮件的在线状态端口（每个用户注册时分配，存在用户信息中）
[40000 - 49999] 通过SMTP发送邮件，临时端口
[30000 - 39999] 通过POP3接收邮件服务器中的邮件，临时端口

发送邮件限制：发送邮件是需要收件方用户处于登陆状态（即端口[50000 - 59999]）
 
### 运行环境：
1. MacOS、Linux系统
Windows系统：不支持pcntl_fork()，子进程创建函数
2. Idea编译器
3. Php，Aphache
4. Php的Socket插件
 
### 配置文件：Config.txt：  
![Image text](https://raw.githubusercontent.com/ok-fine/php_mail_server/master/img-folder/1.png)  
 
### 运行步骤：
1. 运行邮件服务器并后台挂起：“php_mail_server / MailServer / MailServer.php”
![Image text](https://raw.githubusercontent.com/ok-fine/php_mail_server/master/img-folder/2.png)
2. 浏览器打开登陆界面：运行此文件，可自动代开浏览器的登陆界面  
“php_mail_server / Controller / login.php”
3. 注意：发送邮件的必备条件是对方用户在线，所以需要先登录用户1，再退出登录上用户2才能给用户1发送邮件
4. 否则邮件会每个半小时自动重发一次，同时需要用户在线的时候对方在线。（该功能暂时还有问题）


