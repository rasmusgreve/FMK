<?php

interface iPage
{
    /**
     * Make the page consume a form post submission
     * @param string command The current command in the system
     * @param string[] params The current parameters in the system
     * @param User user The currently logged in user
     */
    public function consumePost($command, $params, $user);
    
    /**
     * Display the page content
     * @param string command The current command in the system
     * @param string[] params The current parameters in the system
     * @param User user The currently logged in user
     */
    public function show($command, $params, $user);
}

?>