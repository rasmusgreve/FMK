<?php

class LoginPage implements iPage
{
    private $error = false;
    
    public function consumePost($command, $params, $user)
    {
        if (!isset($_POST['username']) || !isset($_POST['password']))
        {
            return false;
        }
        User::Login($_POST['username'], $_POST['password']);
        if (User::Current()->type == User::USERTYPE_NONE)
        {
            $this->error = true;
            return false;
        }
        
        if (count($params) > 0)
            return './' . $command . '/' . implode('/',$params);
        else
            return './' . $command;
    }
    
    public function show($command, $params, $user)
    {
?>
<div class="container">
    <div class='row'>
        <div class='span6 offset3'>
            <h1>Log ind</h1>
            <form class="well" method="post">
                <?php if ($this->error) { ?>
                <p class=""><i class="icon-exclamation-sign"></i> Ugyldigt brugernavn eller adgangskode</p>
                <?php } ?>
                <label>Brugernavn</label>
                <input type="text" class="span3" tabindex='1' name="username" />
                <a class="help-inline" href='#'  tabindex='5'>Glemt brugernavn?</a>
                <label>Adgangskode</label>
                <input type="password" class="span3" tabindex='2' name="password" />
                <a class="help-inline" href='#' tabindex='6'>Glemt adgangskode?</a>
                <label class="checkbox">
                    <input type="checkbox" tabindex='3'> Husk mig p&aring; denne computer (todo)
                </label>
                <button type="submit" class="btn" tabindex='4'>Log ind</button>
            </form>
        </div>
    </div>
</div> <!-- /container -->
<?php
    }
}

?>