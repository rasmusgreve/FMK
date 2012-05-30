<?php

class Artist
{    
	private $id, ;
	
	public function __construct()
	{
	
	}
	
    public function __construct($id)
    {
        $this->id = $id;
    }
	
	public function Load()
	{
		if ($id == 0)
			return false;
		
		$eventquery = mysql_query("SELECT * FROM `artist` WHERE `id` = '$id' LIMIT 1;");
        if (mysql_num_rows($eventquery) != 1)
        {
            return false;
        }
        $event = mysql_fetch_assoc($eventquery);
        $this->date = $event['date'];
        $this->time = $event['time'];
        $this->visibility = $event['visibility'];
        $this->schedule = $event['schedule'];
        $this->postercount = $event['postercount'];
        $this->honorarium = $event['honorarium'];
        $this->provision = $event['provision'];
        $this->pricemodel = $event['pricemodel'];
        $this->contact = $event['contact'];
        $this->contact_technique = $event['contact_technique'];
        $this->contact_pr = $event['contact_pr'];
        $this->contact_tickets = $event['contact_tickets'];
	}
	
	public function Save()
	{
	
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