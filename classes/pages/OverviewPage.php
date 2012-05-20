<?php

class OverviewPage implements iPage
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
      <div class='span4'>
      </div>
     </div>
      <h1>Koncerter denne uge</h1>
      <table class='eventTable table table-striped table-bordered'>
      <thead>
       <tr><th>Artist</th><th>Spillested</th><th>Dato/Tid</th><th>Status</th><th></th></tr>
       </thead>
       <tbody>
       <?php
       for ($i = 0;$i < 10;$i++)
       {
       ?>
       <tr><td>Emil Nygaard</td><td>Vega</td><td>07/07/2077</td><td>Nyoprettet</td><td><a href='#' class='btn btn-primary'>&Aring;bn</a></td></tr>
       <?php
       }
       ?>
       </tbody>
      </table>
      <hr />
      <h1>Seneste opdateringer</h1>
    </div> <!-- /container -->
<?php
    }
}

?>