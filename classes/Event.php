<?php

class Event
{    
	private $date, $time, $visibility, $schedule, $postercount, $honorarium, $provision, $pricemodel, $contact, $contact_technique, $contact_pr, $contact_tickets $id, $artist, $venue;
	
	public function __construct()
	{
	
	}
	
	public static function FromForm()
	{
		$n = new Event();
		$n->id = $_POST['event_id'];
		$n->date = $_POST['date'];
		$n->time = $_POST['time'];
		$n->visibility = $_POST['visibility'];
		$n->schedule = $_POST['schedule'];
		$n->postercount = $_POST['postercount'];
		$n->honorarium = $_POST['honorarium'];
		$n->provision = $_POST['provision'];
		$n->pricemodel = $_POST['pricemodel'];
		$n->contact = $_POST['contact'];
		$n->contact_technique = $_POST['contact_technique'];
		$n->contact_pr = $_POST['contact_pr'];
		$n->contact_tickets = $_POST['contact_tickets'];
		$n->artist = $_POST['artist'];
        $n->venue = $_POST['venue'];
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
	//if 
	
		$n->date = $_POST['date'];
		$n->time = $_POST['time'];
		$n->visibility = $_POST['visibility'];
		$n->schedule = $_POST['schedule'];
		$n->postercount = $_POST['postercount'];
		$n->honorarium = $_POST['honorarium'];
		$n->provision = $_POST['provision'];
		$n->pricemodel = $_POST['pricemodel'];
		$n->contact = $_POST['contact'];
		$n->contact_technique = $_POST['contact_technique'];
		$n->contact_pr = $_POST['contact_pr'];
		$n->contact_tickets = $_POST['contact_tickets'];
		$n->artist = $_POST['artist'];
        $n->venue = $_POST['venue'];
	
		mysql_query("UPDATE `event` SET 
                    `date` = '$this->date', 
                    `time` = '$this->time',
                    `visibility` = '$this->visibility',
                    `schedule` = '$this->schedule',
                    `postercount` = '$this->postercount',
                    `honorarium` = '$this->honorarium',
                    `provision` = '$this->provision',
                    `pricemodel` = '$this->pricemodel'
                    WHERE `id` = '$this->eventid';");
	}
	
	public function Date()				{return $this->date;}
	public function Time()				{return $this->time;}
	public function Visibility()		{return $this->visibility;}
	public function Schedule()			{return $this->schedule;}
	public function PosterCount()		{return $this->postercount;}
	public function Honorarium()		{return $this->honorarium;}
	public function Provision()			{return $this->provision;}
	public function PriceModel()		{return $this->pricemodel;}
	public function Contact()			{return $this->contact;}
	public function ContactTechnique()	{return $this->contact_technique;}
	public function ContactPR()			{return $this->contact_pr;}
	public function ContactTickets()	{return $this->contact_tickets;}
	
	public function SetDate($v)				{$this->date = $v;}
	public function SetTime($v)				{$this->time = $v;}
	public function SetVisibility($v)		{$this->visibility = $v;}
	public function SetSchedule($v)			{$this->schedule = $v;}
	public function SetPosterCount($v)		{$this->postercount = $v;}
	public function SetHonorarium($v)		{$this->honorarium = $v;}
	public function SetProvision($v)		{$this->provision = $v;}
	public function SetPriceModel($v)		{$this->pricemodel = $v;}
	public function SetContact($v)			{$this->contact = $v;}
	public function SetContactTechnique($v)	{$this->contact_technique = $v;}
	public function SetContactPR($v)		{$this->contact_pr = $v;}
	public function SetContactTickets($v)	{$this->contact_tickets = $v;}
    
}

?>