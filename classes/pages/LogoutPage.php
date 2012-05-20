<?php

class LogoutPage implements iPage
{
    public function consumePost($command, $params, $user)
    {
        unset($_SESSION['currentuser']);
        session_destroy();
        return './';
    }
    
    public function show($command, $params, $user)
    {
        echo "LOGOUT PAGE";
    }
}

?>