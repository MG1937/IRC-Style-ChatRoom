# IRC-Style-ChatRoom
IRC Style Web ChatRoom  
IRC风格的网页聊天室  

聊天室截图
----
![IRC-STYLE-CHATROOM](https://user-images.githubusercontent.com/89259981/161363280-dbb6a70e-3745-4a6c-a55a-8a5bc941df2e.png)

前言
----
这个聊天室我花了一晚上赶着写出来的.  
因为大创要交项目了,所以用来水大创项目用的.  
但后来想想要不直接搭起来用得了.  
目前聊天室测试地址:http://47.99.237.106/  

细节
----

基于PHP的单线程聊天室,  
因为最开始是为了在自己的笔记本上简易搭建一个聊天服务,考虑到笔记本的处理能力,   
所以使用WebSocket之类的组件维持几十个长连接来更新聊天室内的对话总觉得不现实,   
所以就简单用请求不断轮询.   

使用
----

用法:  
```
php ServerBuilder.php
```
在命令行使用PHP运行ServerBuilder.php即可简易搭建一个聊天服务器.  
