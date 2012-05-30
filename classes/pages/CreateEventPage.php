<?php

class CreateEventPage implements iPage
{
    private $artist_error = false;
    private $venue_error = false;
    private $artist_name = '';
    private $venue_name = '';
    
    public function consumePost($command, $params, $user)
    {
        if (!isset($_POST['artist']) || !isset($_POST['venue']))
        {
            return false;
        }
        
        $this->artist_name = $_POST['artist'];
        $this->venue_name = $_POST['venue'];
        
        $artist_query = mysql_query("SELECT * FROM `artist` WHERE `name` = '".  mysql_real_escape_string($_POST["artist"])."' LIMIT 1;");
        $venue_query = mysql_query("SELECT * FROM `venue` WHERE `name` = '".  mysql_real_escape_string($_POST["venue"])."' LIMIT 1;");
        
        //Validation
        if (mysql_num_rows($artist_query) == 0)
            $this->artist_error = true;
        if (mysql_num_rows($venue_query) == 0)
            $this->venue_error = true;
        if ($this->artist_error || $this->venue_error)
            return false; //Redisplay the page to inform the user
        
        $artist = mysql_fetch_assoc($artist_query);
        $venue = mysql_fetch_assoc($venue_query);
              
        //Creation
        $creationtoken = time();
        mysql_query("INSERT INTO `event` (`artist`, `venue`, `date`, `creationtoken`) VALUES ('{$artist['id']}', '{$venue['id']}', '".date( 'Y-m-d H:i:s')."', '$creationtoken');");
        $event_query = mysql_query("SELECT `id` FROM `event` WHERE `creationtoken` = '$creationtoken' LIMIT 1;");
		$eventid = mysql_result($event_query, 0, 0);
		
		$this->setContact('contact', $venue['id'], $eventid);
		$this->setContact('contact_technique', $venue['id'], $eventid);
		$this->setContact('contact_pr', $venue['id'], $eventid);
		$this->setContact('contact_tickets', $venue['id'], $eventid);
		
        //Redirection
        return "./event/$eventid";
    }
    
	private function setContact($type, $venueid, $eventid)
	{
		mysql_query("UPDATE `event` e SET e.`$type` = (SELECT `$type` FROM `venue` v WHERE v.`id` = '$venueid' LIMIT 1) WHERE e.`id` = '$eventid' LIMIT 1;");
	}
	
    public function show($command, $params, $user)
    {
        $artists_query = mysql_query("SELECT * FROM `artist`;");
        $artists = array();
        while ($res = mysql_fetch_assoc($artists_query))
        {
            $artists[] = '"'.$res["name"].'"';
        }
        
        $venues_query = mysql_query("SELECT * FROM `venue`;");
        $venues = array();
        while ($res = mysql_fetch_assoc($venues_query))
        {
            $venues[] = '"'.$res["name"].'"';
        }
        
        
        ?>
<div class="container">
    <div class='row'>
        <div class=''>
            <form class="well form-horizontal" method="post" action="./newevent" autocomplete="off">
                <fieldset>
                    <legend>Tilf&oslash;j ny koncert</legend>
                    <div class="control-group">
                        <label class="control-label" for="artist">Kunstner</label>
                        <div class="controls">
                            <input type="text" autocomplete="off" value="<?php echo $this->artist_name;?>" id='artist' class="input-xlarge" name='artist' data-provide="typeahead" data-items="4" data-source='[<?php echo implode(",",$artists);?>]'>
                            <?php if ($this->artist_error) { ?>
                            <p class="help-block"><i class="icon-exclamation-sign"></i> Ugyldig kunstner</p>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="venue">Venue</label>
                        <div class="controls">
                            <input type="text" autocomplete="off" value="<?php echo $this->venue_name;?>" id='venue' class="input-xlarge" name='venue' data-provide="typeahead" data-items="4" data-source='[<?php echo implode(",",$venues);?>]'>
                            <?php if ($this->venue_error) { ?>
                            <p class="help-block"><i class="icon-exclamation-sign"></i> Ugyldigt venue</p>
                            <?php } ?>
                        </div>
                        
                    </div>

                    <div class="control-group"> 
                        <div class="controls">
                            <input type="submit" class="btn btn-primary btn-large" value="Opret koncert">
                            <a class="btn btn-large" href="./">Annuller</a>
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
</div>

<?php
    }
}

?>