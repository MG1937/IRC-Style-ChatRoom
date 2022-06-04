# IRC-Style-ChatRoom
IRC Style Web ChatRoom  
IRC风格的网页聊天室  

聊天室截图
----
![IRC-STYLE-CHATROOM](https://user-images.githubusercontent.com/89259981/161363280-dbb6a70e-3745-4a6c-a55a-8a5bc941df2e.png)

前言
----
花了两个小时写的IRC风格的聊天室,   
用来应付大创项目用的...   

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
