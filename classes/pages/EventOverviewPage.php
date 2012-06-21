<?php

class EventOverviewPage implements iPage
{
    public function consumePost($command, $params, $user)
    {
        return false;
    }
    
    public function show($command, $params, $user)
    {
		echo "Corresponding: " . User::Current()->corresponding_id;
		$where = "";
		if (User::Current()->type == User::USERTYPE_FMK)
			$where = "";
		if (User::Current()->type == User::USERTYPE_ARTIST)
			$where = "AND ".User::Current()->corresponding_id." = a.`id`";
		if (User::Current()->type == User::USERTYPE_VENUE)
			$where = "AND ".User::Current()->corresponding_id." = v.`id`";
			
		$q = mysql_query("SELECT e.*, a.`name` as `artist_name`, v.`name` as `venue_name` FROM `event` e, `artist` a, `venue` v
			WHERE e.`venue` = v.`id` AND e.`artist` = a.`id` $where ORDER BY e.`date` ASC LIMIT 10;");
		
        ?>
    <div class="container">
     <div class='row'>
      <div class='span4'>
      </div>
     </div>
      <h1>Kommende koncerter</h1>
      <table class='eventTable table table-striped table-bordered'>
      <thead>
       <tr><th>Artist</th><th>Spillested</th><th>Dato/Tid</th><th>Status</th><th></th></tr>
       </thead>
       <tbody>
       <?php
	   while ($res = mysql_fetch_assoc($q))
	   {
			echo "<tr><td>{$res['artist_name']}</td><td>{$res['venue_name']}</td><td>{$res['date']}</td><td>Todo</td><td></td>";
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