<?php
include_once('db.php');

class User
{
    // property declaration
    private $id;
    private $firstname;
	private $lastname;
	private $slackid;
	private $email;
    private $username;
    private $password; //stored in MD5
    private $isAdmin; //0 -> not admin, 1 -> is admin
    // method declaration
    public function getId(){
    	return $this->id;
    }

    public function setFirstname($firstname){
    	$this->firstname = $firstname;
    }

    public function getFirstname(){
    	return $this->firstname;
    }

    public function setLastname($lastname){
    	$this->lastname = $lastname;
    }

    public function getLastname(){
    	return $this->lastname;
    }

    public function setSlackid($slackid){
    	$this->slackid = $slackid;
    }

    public function getSlackid(){
    	return $this->slackid;
    }

    public function setEmail($email){
    	$this->email = $email;
    }

    public function getEmail(){
    	return $this->email;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getIsAdmin(){
        if ($this->isAdmin == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function passwordIsOK() {

        $db = new Db();
        $db->connect();
        //($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null)
        $where = "username = '" . $db->escapeString($this->username) . "' AND password = '" . $this->password . "' AND isadmin = " . 1 ;
        $db->select('users', '*', null, $where);
        if ($db->numRows() > 0){
            $data = $db->getResult();
            $this->id = $data[0]["id"];
            $this->firstname = $data[0]["firstname"];
            $this->lastname = $data[0]["lastname"];
            $this->slackid = $data[0]["slackid"];
            $this->email = $data[0]["email"];
            $this->username = $data[0]["username"];
            $this->isAdmin = $data[0]["isadmin"];
            return true;
        } else {
            return false;
        }
        
    }

	public function loadFromDBwithID($id) {

		$db = new Db();
		$db->connect();
		//select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null)
		$db->select('users', '*', null, "id = '" . $id . "'");
		if ($db->numRows() > 0){
			$data = $db->getResult();
			$this->id = $id;
			$this->firstname = $data[0]["firstname"];
			$this->lastname = $data[0]["lastname"];
			$this->slackid = $data[0]["slackid"];
			$this->email = $data[0]["email"];
            $this->username = $data[0]["username"];
            $this->isAdmin = $data[0]["isadmin"];
			return true;
		} else {
			return false;
		}
		
	}
}
?>