<?php

class User
{
    const USERTYPE_NONE = 'none';
    const USERTYPE_FMK = 'fmk';
    const USERTYPE_ARTIST = 'artist';
    const USERTYPE_VENUE = 'venue';
    
    public $type, $id, $username, $email;
    
    public static function Current()
    {
        if (!isset($_SESSION['currentuser']))
        {
            $_SESSION['currentuser'] = self::None();
        }
        return $_SESSION['currentuser'];
    }
    
    private function __construct($type, $id = 0, $username = '', $email = '')
    {
        $this->type = $type;
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
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
        $newUser = new User($row['type'],$row['id'],$row['username'],$row['email']);
        $_SESSION['currentuser'] = $newUser;
        return $newUser;
    }
}

?>