<?php
/*
 * AUTH:MG193.7
 * AUTH:12021052020程为民
 */
include(__DIR__.'/Chat/Config.php');

error_reporting(0);

set_time_limit(0);

$uname = $_REQUEST['u'];
if(!isset($uname)||strlen($uname) >= 10||$uname == "NuN"||$uname == "undefined") return;
$msg = $_POST['d'];

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_connect($socket, '127.0.0.1', S_PORT);
socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec"=>5, "usec"=>0));

$callback = "[]";
switch ($_GET['a']) {
	case 'send':
	{
		socket_write($socket, "2*${uname}*${msg}");
		$callback = socket_read($socket, 2048);
		break;
	}

	case 'get':
	{
		socket_write($socket, "3*${uname}*");
		$callback = socket_read($socket, 2048);
		break;
	}

	case 'alluser':
	{
		socket_write($socket, "4*${uname}*");
		$callback = socket_read($socket, 20480);
		break;
	}

	case 'extuser':
	{
		socket_write($socket, "5*${uname}*${msg}");
		$callback = socket_read($socket, 2048);
		break;
	}
}
socket_close($socket);

echo $callback;

