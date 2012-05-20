<?php

class SettingsPage implements iPage
{
    public function consumePost($command, $params, $user)
    {
        return false;
    }
    
    public function show($command, $params, $user)
    {
        echo "Settings";
    }
}

?>