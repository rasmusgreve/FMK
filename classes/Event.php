<?php

class Event
{    
	public $date, $time, $visibility, $schedule, $postercount, $honorarium, $provision, $pricemodel, $contact, $contact_technique, $contact_pr, $contact_tickets, $id, $artist, $venue;
	
	public function __construct()
	{
	
	}
	
	public static function ValidateForm()
	{
		$errors = array();
		//ID
		if (!isset($_POST['event_id']) || !ctype_digit($_POST['event_id']))
			$errors['event_id'] = 'Arrangements ID (burde ikke opst&aring; kontakt os venligst p&aring; TODO: email her';
		else
		{
			if ($_POST['event_id'] != 0)
			{
				$id_query = mysql_query("SELECT * FROM `event` WHERE `id` = '".$_POST['event_id']."' LIMIT 1;");
				if (mysql_num_rows($id_query) != 1)
					$errors['event_id'] = 'Arrangements ID (burde ikke opst&aring; kontakt os venligst p&aring; TODO: email her';
			}
		}
		//Date
		if (!isset($_POST['date']))
			$errors['date'] = true;
		else
		{
			$matches = array();
			if (!preg_match('/(\d{1,4})-(\d{1,2})-(\d{1,2})/',$_POST['date'],$matches))
				$errors['date'] = true;
			else
			{
				if ($matches[2] > 12 || $matches[2] < 1 || $matches[3] > 31 || $matches[3] < 1)
					$errors['date'] = true;
			}
		}
		//Time
		if (!isset($_POST['time']))
			$errors['time'] = true;
		else
		{
			$matches = array();
			if (!preg_match('/(\d{1,2}):(\d{1,2})/',$_POST['time'],$matches))
				$errors['time'] = true;
			else
			{
				if ($matches[1] > 23 || $matches[2] > 59)
					$errors['time'] = true;
			}
		}
		//Visibility
		if (!isset($_POST['visibility']))
			$errors['visibility'] = true;
		else
		{
			if ($_POST['visibility'] != 'public' && $_POST['visibility'] != 'tba' && $_POST['visibility'] != 'reservation')
				$errors['visibility'] = true;
		}
		//Schedule
		if (!isset($_POST['schedule']))
			$errors['schedule'] = true;
		//Postercount
		if (!isset($_POST['postercount']) || !ctype_digit($_POST['postercount']))
			$errors['postercount'] = true;
		//Honorarium
		if (!isset($_POST['honorarium']) || !is_numeric($_POST['honorarium']))
			$errors['honorarium'] = true;
		//Provision
		if (!isset($_POST['provision']) || !is_numeric($_POST['provision']))
			$errors['provision'] = true;
		//Pricemodel
		if (!isset($_POST['pricemodel']))
			$errors['pricemodel'] = true;
		else
		{
			if ($_POST['pricemodel'] != 'flatfee' && $_POST['pricemodel'] != 'bonus')
				$errors['pricemodel'] = true;
		}
		//Contact
		if (!isset($_POST['contact']) || !ctype_digit($_POST['contact']))
			$errors['contact'] = true;
		else
		{
			if ($_POST['contact'] != 0)
			{
				$contact_query = mysql_query("SELECT * FROM `contact` WHERE `id` = '".$_POST['contact']."' LIMIT 1;");
				if (mysql_num_rows($contact_query) != 1)
					$errors['contact'] = true;
			}
		}
		//Contact technique
		if (!isset($_POST['contact_technique']) || !ctype_digit($_POST['contact_technique']))
			$errors['contact_technique'] = true;
		else
		{
			if ($_POST['contact_technique'] != 0)
			{
				$contact_query = mysql_query("SELECT * FROM `contact` WHERE `id` = '".$_POST['contact_technique']."' LIMIT 1;");
				if (mysql_num_rows($contact_query) != 1)
					$errors['contact_technique'] = true;
			}
		}
		//Contact pr
		if (!isset($_POST['contact_pr']) || !ctype_digit($_POST['contact_pr']))
			$errors['contact_pr'] = true;
		else
		{
			if ($_POST['contact_pr'] != 0)
			{
				$contact_query = mysql_query("SELECT * FROM `contact` WHERE `id` = '".$_POST['contact_pr']."' LIMIT 1;");
				if (mysql_num_rows($contact_query) != 1)
					$errors['contact_pr'] = true;
			}
		}
		//Contact tickets
		if (!isset($_POST['contact_tickets']) || !ctype_digit($_POST['contact_tickets']))
			$errors['contact_tickets'] = true;
		else
		{
			if ($_POST['contact_tickets'] != 0)
			{
				$contact_query = mysql_query("SELECT * FROM `contact` WHERE `id` = '".$_POST['contact_tickets']."' LIMIT 1;");
				if (mysql_num_rows($contact_query) != 1)
					$errors['contact_tickets'] = true;
			}
		}
		
		//Artist
		if (!isset($_POST['artist']) || !ctype_digit($_POST['artist']))
			$errors['artist'] = true;
		else
		{
			$artist_query = mysql_query("SELECT * FROM `artist` WHERE `id` = '".$_POST['artist']."' LIMIT 1;");
			if (mysql_num_rows($artist_query) != 1)
				$errors['artist'] = true;
		}
		//Venue
		if (!isset($_POST['venue']) || !ctype_digit($_POST['venue']))
			$errors['venue'] = true;
		else
		{
			$venue_query = mysql_query("SELECT * FROM `venue` WHERE `id` = '".$_POST['venue']."' LIMIT 1;");
			if (mysql_num_rows($venue_query) != 1)
				$errors['venue'] = true;
		}
			
		return $errors;
	}
	
	private static function TryGetFromPost($v)
	{
		return (isset($_POST[$v])) ? mysql_real_escape_string($_POST[$v]) : '';
	}
	
	public static function FromForm()
	{
		$n = new Event();
		$n->id = self::TryGetFromPost('event_id');
		$n->date = self::TryGetFromPost('date');
		$n->time = self::TryGetFromPost('time');
		$n->visibility = self::TryGetFromPost('visibility');
		$n->schedule = self::TryGetFromPost('schedule');
		$n->postercount = self::TryGetFromPost('postercount');
		$n->honorarium = self::TryGetFromPost('honorarium');
		$n->provision = self::TryGetFromPost('provision');
		$n->pricemodel = self::TryGetFromPost('pricemodel');
		$n->contact = self::TryGetFromPost('contact');
		$n->contact_technique = self::TryGetFromPost('contact_technique');
		$n->contact_pr = self::TryGetFromPost('contact_pr');
		$n->contact_tickets = self::TryGetFromPost('contact_tickets');
		$n->artist = self::TryGetFromPost('artist');
        $n->venue = self::TryGetFromPost('venue');
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