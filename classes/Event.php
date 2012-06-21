<?php

class Event
{    
	public $date, $time, $visibility, $schedule, $postercount, $honorarium, $provision, $pricemodel, $contact, $contact_technique, $contact_pr, $contact_tickets, $id, $artist, $venue;
	
	public function __construct()
	{
	
	}
	
	public static function FromForm()
	{
		$n = new Event();
		$n->id = mysql_real_escape_string($_POST['event_id']);
		$n->date = mysql_real_escape_string($_POST['date']);
		$n->time = mysql_real_escape_string($_POST['time']);
		$n->visibility = mysql_real_escape_string($_POST['visibility']);
		$n->schedule = mysql_real_escape_string($_POST['schedule']);
		$n->postercount = mysql_real_escape_string($_POST['postercount']);
		$n->honorarium = mysql_real_escape_string($_POST['honorarium']);
		$n->provision = mysql_real_escape_string($_POST['provision']);
		$n->pricemodel = mysql_real_escape_string($_POST['pricemodel']);
		$n->contact = mysql_real_escape_string($_POST['contact']);
		$n->contact_technique = mysql_real_escape_string($_POST['contact_technique']);
		$n->contact_pr = mysql_real_escape_string($_POST['contact_pr']);
		$n->contact_tickets = mysql_real_escape_string($_POST['contact_tickets']);
		$n->artist = mysql_real_escape_string($_POST['artist']);
        $n->venue = mysql_real_escape_string($_POST['venue']);
		return $n;
	}
	
	public static function FromDB($id)
	{
		if ($id == 0 || !ctype_digit($id))
			return null;
		
		$eventquery = mysql_query("SELECT * FROM `event` WHERE `id` = '$id' LIMIT 1;");
        if (mysql_num_rows($eventquery) != 1)
            return null;
			
        $event = mysql_fetch_assoc($eventquery);
		
		$n = new Event();
        $n->id = $id;
        $n->date = $event['date'];
        $n->time = $event['time'];
        $n->visibility = $event['visibility'];
        $n->schedule = $event['schedule'];
        $n->postercount = $event['postercount'];
        $n->honorarium = $event['honorarium'];
        $n->provision = $event['provision'];
        $n->pricemodel = $event['pricemodel'];
        $n->contact = $event['contact'];
        $n->contact_technique = $event['contact_technique'];
        $n->contact_pr = $event['contact_pr'];
        $n->contact_tickets = $event['contact_tickets'];
        $n->artist = $event['artist'];
        $n->venue = $event['venue'];
		return $n;
	}
	
	public function Save()
	{
		if 	($this->id == 0)
		{
			mysql_query("INSERT INTO `fmk`.`event` (`artist`, `venue`, `date`, `time`, `visibility`, `schedule`, `postercount`, `honorarium`, `provision`, `pricemodel`, `contact`, `contact_technique`, `contact_pr`, `contact_tickets`, `creationtoken`) VALUES ({$this->artist},{$this->venue},{$this->date},{$this->time},{$this->visibility},{$this->schedule},{$this->postercount},{$this->honorarium},{$this->provision},{$this->pricemodel},{$this->contact},{$this->contact_technique},{$this->contact_pr},{$this->contact_tickets},{$this->creationtoken});");
			$q = mysql_query("SELECT `id` FROM `event` WHERE `creationtoken` = '{$this->creationtoken}' LIMIT 1;");
			$this->id = mysql_result($q,0,0);
		}
		else
		{
			mysql_query("UPDATE `event` SET 
					`artist` = '{$this->artist}',
					`venue` = '{$this->venue}',
					`date` = '{$this->date}',
					`time` = '{$this->time}',
					`visibility` = '{$this->visibility}',
					`schedule	` = '{$this->schedule}',
					`postercount` = '{$this->postercount}',
					`honorarium` = '{$this->honorarium}',
					`provision` = '{$this->provision}',
					`pricemodel` = '{$this->pricemodel}',
					`contact` = '{$this->contact}',
					`contact_technique` = '{$this->contact_technique}',
					`contact_pr` = '{$this->contact_pr}',
					`contact_tickets` = '{$this->contact_tickets}'
                    WHERE `id` = '$this->eventid';");
		}
	}
}

?>