<?php

class User
{
    const USERTYPE_NONE = 'none';
    const USERTYPE_FMK = 'fmk';
    const USERTYPE_ARTIST = 'artist';
    const USERTYPE_VENUE = 'venue';
    
    public $type, $id, $username, $email;
	public $corresponding_id;
    
    public static function Current()
    {
		print_r($_SESSION);
		echo "<br>";
		echo "<br>";
		echo "<br>";
        if (!isset($_SESSION['currentuser']))
        {
            $_SESSION['currentuser'] = serialize(self::None());
        }
        return unserialize($_SESSION['currentuser']);
    }
    
    private function __construct($type, $id = 0, $username = '', $email = '', $corresponding_id = null)
    {
        $this->type = $type;
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->corresponding_id = $corresponding_id;
    }
    
    public static function None()
    {
        return new User(self::USERTYPE_NONE);
    }
    
    public static function Login($username,$password)
    {
        $username = mysql_real_escape_string($username);
        $password = hash('sha256',$password);
        $query = mysql_query("SELECT * FROM `user` WHERE `username` = '$username' AND `password` = '$password' LIMIT 1;");
        if (mysql_num_rows($query) == 0)
            return new User(self::USERTYPE_NONE);
        $row = mysql_fetch_assoc($query);
        $newUser = new User($row['type'],$row['id'],$row['username'],$row['email'],$row['corresponding_id']);
        $_SESSION['currentuser'] = serialize($newUser);
        return $newUser;
    }
}

?>