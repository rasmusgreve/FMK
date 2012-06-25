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
        echo "Logout page. If you read this text you are logged out, but was not redirected for some reason.";
    }
}

?>