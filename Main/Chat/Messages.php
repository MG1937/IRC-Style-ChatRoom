<?
/*
 * AUTH:MG193.7
 */

//消息缓存区
class Messages
{
	private $users;
	private $latestMsgTime;
	private $messagePool;

	function __construct($users)
	{
		$this->latestMsgTime = 0;
		$this->users = $users;
		$this->messagePool = array();
	}

	public function addMessage($uname,$message)
	{
		$now = (new DateTime())->getTimestamp();
		if($now - $this->latestMsgTime >= 30)
		{
			unset($this->messagePool);
			$this->messagePool = array();
		}
		$this->users->userAlive($uname);
		array_push($this->messagePool, array($uname, ($message) === NULL ? "":$message));
		$this->users->updateNewMessage($uname);
		$this->latestMsgTime = $now;
	}

	public function getNewMessage($uname)
	{
		$this->users->userAlive($uname);
		$msgs = $this->users->getUser($uname)[1];
		if($msgs)
		{
			echo "getMsg $uname\r\n";
			$this->users->users[$uname][1] = 0;
			return json_encode(array_slice($this->messagePool, -($msgs)));
		}
		return "[]";
	}	
}