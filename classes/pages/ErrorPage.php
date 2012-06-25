<?php

class ErrorPage implements iPage
{

    public function consumePost($command, $params, $user)
    {
        return false;
    }
    
    public function show($command, $params, $user)
    {
?>
<div class="container">
    <div class='row'>
        <div class='span6 offset3'>
            <h1>Der opstod en fejl</h1>
            <div class="well">
				<p>Der opstod en fejl under visning af den forespurgte side.<br/>
				Det kan skyldes at du har en fejl i den indtastede URL, eller at du ikke har adgang til siden</p>
				<p>DEBUG Nuværende brugertype: <?php echo User::Current()->type;?><br/>
				Forespurgt side: <?php echo $command;?> DEBUG</p>
                <p>Muligheder:</p>
				<ul>
					<li>Gå til <a href='./'>forsiden</a></li>
					<li><a href='./logout'>Log ud og log ind igen</a></li>
					<li>TODO:<a href='mailto:derp@example.com'>Send os en mail</a></li>
					<li>Prøv igen senere</li>
				</ul>
            </div>
        </div>
    </div>
</div> <!-- /container -->
<?php
    }
}

?>