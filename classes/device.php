<?php
include_once('db.php');
include_once('user.php');

class Device
{
    // property declaration
    private $user_id; //this is the user_id of the database
    private $user; //this is an object
    private $mac;
    private $vendor;
    // method declaration
    public function getUser(){
    	return $this->user;
    }

    public function setUser($user){
    	$this->user = $user;
    }

    public function setMac($mac){
    	$this->mac = $mac;
    }

    public function getMac(){
    	return $this->mac;
    }

    public function setVendor($vendor){
        $this->vendor = $vendor;
    }

    public function getVendor(){
        return $this->vendor;
    }

    public function getUserId(){
    	return $this->user_id;
    }

	public function loadFromDBwithMAC($mac) {

		$db = new Db();
		$db->connect();
		//select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null)
		$db->select('devices', '*', null, "mac = '" . $mac . "'");
		if ($db->numRows() > 0){
			$data = $db->getResult();
			$this->user_id = $data[0]["user_id"];
			$this->mac = $mac;
			$this->vendor = $data[0]["vendor"];
            $this->user = new User();
            $this->user->loadFromDBwithID($this->user_id);
			return true;
		} else {
			return false;
		}
		
	}
}
?>