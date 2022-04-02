/*
 * AUTH:MG193.7
 * AUTH:12021052020程为民
 */

if(navigator.userAgent.indexOf('Android') != -1)
{
	alert('NOT SUPPORT ANDROID YET!!');
}

var colors = ['#1E90FF','#DEB887','#FF0000','#00FFFF','#AFEEEE','#00FA9A'];
var usercol = {};
var usersmsg = {};

var xmlhttp = new XMLHttpRequest();
var uname = "NuN"
var temp = "";
var chatwindow = document.getElementById('chatwindow');
var msginput = document.getElementById('msginput');
var userlist = document.getElementById('userlist');

document.getElementById('uname').textContent = uname;
msginput.focus();

window.onkeypress = (function(e){
	if(e.key === "Enter")
	{
		sendMessage(msginput.value);
		msginput.value = "";
		msginput.focus();
	}
});

function register()
{
	flushUserList();
	chatwindow.innerHTML += 
	"<font>YOU NEED TO REGIST FIRST!<br>"+
	"OR YOU WILL NOT RECEIVE ANY MSG UNTIL YOU REGIST!!<br>"+
	"Type /nick &lt;NAME&gt; to set your Nickname.<br>"+
	"请先注册您的账户!<br>"+
	"在您成功注册账户前您将不会收到聊天室内的任何聊天!<br>"+
	"使用命令'/nick 名字'以注册您的用户!<br>"+
	"</font>";
}

function requestChatServer(action,data,tempName)
{
	try
	{
		if(tempName == null) tempName = uname;
		var type = data === null ? "GET":"POST";
		xmlhttp.open(type,"./Main/GainChater.php?a=" + action + "&u=" + tempName,true);
		xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xmlhttp.onreadystatechange = (function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				data = xmlhttp.responseText;
				console.log(data);
				switch(action)
				{
					case 'get':
					{
						updateChatWindow(JSON.parse(data));
						break;
					}
					case 'alluser':
					{
						updateUserList(JSON.parse(data));
						break;
					}
				}
			}
		})
		xmlhttp.send(data);
	}
	catch(err)
	{
		return null;
	}
}

function flushUserList()
{
	requestChatServer('alluser',null,"temp");
}

function updateUserList(json)
{
	if(json === null) return;
	usersmsg = json;
	userlist.innerHTML = "";
	for(v in json)
	{
		if(v === "NuN"||v === "undefined") continue;
		var d_user = document.createElement('div');
		var user = document.createElement('p');
		user.innerText = v;
		d_user.appendChild(user);
		userlist.appendChild(d_user);
	}
}

function updateChatWindow(json)
{
	if(json === null) return;
	var context = "";
	json.forEach(function(v){
		if(v[0] === uname) return;
		addMsg(v);
	});
}

function addLocalMsg(data)
{
	var msgDiv = document.createElement("div");
	var msg = document.createElement("span");
	msg.color = "white";
	msg.innerText = data;
	msgDiv.appendChild(msg);
	chatwindow.appendChild(msgDiv);
	chatwindow.scrollTop = chatwindow.scrollHeight;
}

function addMsg(v)
{
	if(usercol[v[0]] == null)
	{
		usercol[v[0]] = colors[Math.floor(Math.random() * colors.length)];
	}
	var msgDiv = document.createElement("div");
	var u_name = document.createElement("font");
	u_name.color = uname === v[0] ? "yellow":usercol[v[0]];
	u_name.innerText = "[" + v[0] + "]";
	msgDiv.appendChild(u_name);
	var msg = document.createElement("span");
	msg.color = "white";
	msg.innerText = " " + v[1];
	msgDiv.appendChild(msg);
	chatwindow.appendChild(msgDiv);
	chatwindow.scrollTop = chatwindow.scrollHeight;
}

function updateMessage()
{
	requestChatServer('get');
}

function localCMDHandler(data)
{
	var datas = data.split(" ");
	switch(datas[0])
	{
		case "/nick":
		{
			if(usersmsg[datas[1]] != null)
			{
				addLocalMsg(datas[1] + " is ALREADY in Chat Room!!\nPlease Change YOUR NAME!!");
				return true;
			}
			uname = datas[1];
			document.getElementById('uname').textContent = uname;
			addLocalMsg("You are now as " + uname + " in Chat Room\n");
			return true;
		}
	}
}

function sendMessage(data)
{
	if(localCMDHandler(data)) return;
	if(uname === "NuN")
	{
		addLocalMsg("YOU DO NOT REGIST YET!!\nType /nick <NAME> to set your Nickname.");
		return;
	}
	requestChatServer("send","d=" + data);
	addMsg([uname,data]);
}

register();
setInterval("updateMessage()",1000);
setInterval("flushUserList()",10000);