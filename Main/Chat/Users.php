<?
/*
 * AUTH:MG193.7
 */

class Users
{
	/* users[uname][0] = aliveTime
	 * users[uname][1] = newMessage
	 */
	public $users;
	
	function __construct()
	{
		$this->users = array();
	}

	public function getUser($uname)
	{
		return $this->users[$uname];
	}

	public function userAlive($uname)
	{
		if(!isset($this->users[$uname]))
		{
			$this->users[$uname] = array(0,0);
		}

		$this->users[$uname][0] = (new DateTime())->getTimestamp();
	}

	public function isDie($uname)
	{
		$now = (new DateTime())->getTimestamp();
		if($now - $this->users[$uname][0] >= 10)
		{
			echo "remove $uname\r\n";
			$this->removeUser($uname);
			return true;
		}
		return false;
	}

	public function getUserTable()
	{
		return json_encode($this->users);
	}

	public function removeUser($uname)
	{
		unset($this->users[$uname]);
	}

	public function updateNewMessage($uname)
	{
		foreach ($this->users as $key => $value) {
			//if($uname === $key) continue;//跳过消息发送者
			if(!$this->isDie($key))
			{
				$this->users[$key][1] += 1;
			}
		}
	}
}