<?php
/*
 * AUTH:MG193.7
 * AUTH:12021052020程为民
 */
include(__DIR__.'/Chat/Users.php');
include(__DIR__.'/Chat/Messages.php');
include(__DIR__.'/Chat/Config.php');

$users = new Users();
$messages = new Messages($users);

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING);
set_time_limit(0);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($socket, '127.0.0.1', S_PORT);
socket_listen($socket);

socket_set_option($socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>5, "usec"=>0));

function socketAccept($socket)
{
	$read = socket_read($socket,MAX_READ);
	echo "$read\r\n";
	if(!$read) return;
	$packs = explode("*", $read, 3);
	socket_write($socket, actionHandler($packs));
	socket_close($socket);
}

function actionHandler($packs)
{
	global $users,$messages;

	$action = $packs[0];
	$uname = $packs[1];
	$data = $packs[2];

	$callback = "[]";
	switch ($action) {
		case ACTION_ALIVE:
		{
			$users->userAlive($uname);
			break;
		}

		case ACTION_SEND:
		{
			$messages->addMessage($uname,$data);
			break;
		}

		case ACTION_GETMSG:
		{
			$callback = $messages->getNewMessage($uname);
			break;
		}

		case ACTION_ALLUSER:
		{
			$callback = json_encode($users->users);
			break;
		}

		case ACTION_EXTUSER:
		{
			$callback = json_encode($users->getUser($data));
			break;
		}
	}

	if($callback === "null") $callback = "[]";

	return $callback;
}

while(true)
{
    socketAccept(socket_accept($socket));
}
echo "DONE";