<?php

class ViewEventPage implements iPage
{
    private $date, $time, $visibility, $schedule, $postercount, $honorarium, $provision, $pricemodel, $contact, $contact_technique, $contact_pr, $contact_tickets;
    private $eventid = -1;
    private $artistname, $venuename;
	
	private $possible_contacts = array();
	
	private function loadFromId($id)
	{
		$id = mysql_real_escape_string($id);

		
		//Get event data
		$eventquery = mysql_query("SELECT e.*, a.`name` as artistname, v.`name` as venuename FROM `event` e, `artist` a, `venue` v WHERE e.`artist` = a.`id` AND e.`venue` = v.`id` AND e.`id` = '$id' LIMIT 1;");
        if (mysql_num_rows($eventquery) != 1)
        {
            //TODO: Error handling
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
        $this->artistname = $event['artistname'];
        $this->venuename = $event['venuename'];
		
		
		$this->possible_contacts = array();
		//Get venue contacts
		$contacts_query = mysql_query("SELECT * FROM `contact` WHERE `venue` = '{$event['venue']}';");
		while ($res = mysql_fetch_assoc($contacts_query))
		{
			$this->possible_contacts[] = array('id' => $res['id'], 'name' => $res['name'] . " - " . $res['phone']);
		}
	}
	
	private function getPossibleContacts($selected_id)
	{
		$possible_contacts_as_options = "<option value='0'>V&aelig;lg kontaktperson</option>";
		foreach ($this->possible_contacts as $contact)
		{
			if ($selected_id == $contact['id'])
			{
				$possible_contacts_as_options .= "<option value='{$contact['id']}' selected>{$contact['name']}</option>";
			}
			else
			{
				$possible_contacts_as_options .= "<option value='{$contact['id']}'>{$contact['name']}</option>";
			}
		}
		return $possible_contacts_as_options;
	}
		
    public function consumePost($command, $params, $user)
    {
        if (count($params) > 0 && is_numeric($params[0]))
            $this->eventid = $params[0];
		
		if (isset($_POST['delete']))
		{
			mysql_query("INSERT INTO `deleted_event` (SELECT * FROM `event` WHERE `id` = '{$this->eventid}');");
			mysql_query("UPDATE `deleted_event` SET `creationtoken` = '".time()."' WHERE `id` = '{$this->eventid}';"); //Save deletion time
			mysql_query("DELETE FROM `event` WHERE `id` = '{$this->eventid}' LIMIT 1;");
			return "./"; //TODO: Informer brugeren om hvad der er sket
		}
        $this->loadFromId($this->eventid);
        
        if (!isset($_POST["date"]))
            return false;
        else
        {
            $this->date = $_POST['date'];
            $this->time = $_POST['time'];
            $this->visibility = $_POST['visibility'];
            $this->schedule = $_POST['schedule'];
            $this->postercount = $_POST['postercount'];
            $this->honorarium = $_POST['honorarium'];
            $this->provision = $_POST['provision'];
            $this->pricemodel = $_POST['pricemodel'];
            $this->contact = $_POST['contact'];
            $this->contact_technique = $_POST['contact_technique'];
            $this->contact_pr = $_POST['contact_pr'];
            $this->contact_tickets = $_POST['contact_tickets'];
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
            //TODO: Escape
            return false;
        }
    }
    
    public function show($command, $params, $user)
    {
		if (count($params) == 0)
		{
			$params[] = "";
		}
		$this->loadFromId($params[0]);
		
        ?>
<div class="container">
    <div class='row'>
        <div class=''>
            <form class="well form-horizontal" method="post">
                <input type="hidden" name="id" value="<?php echo $this->eventid; ?>">
                <fieldset>
                    <legend>Koncert</legend>
                    <div class="control-group">
                        <label class="control-label" for="artist">Kunstner:</label>
                        <div class="controls">
                            <span class="uneditable-input"><?php echo $this->artistname;?></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="venue">Venue:</label>
                        <div class="controls">
                            <span class="uneditable-input"><?php echo $this->venuename;?></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="contact">Kontaktperson:</label>
                        <div class="controls">
                            <select id="contact" name="contact">
								<?php echo $this->getPossibleContacts($this->contact);?>
                            </select>
                            <a href='./event#' onclick='$("#moreContacts").collapse("toggle");$("#moreDown").toggle();$("#moreUp").toggle();return false;' class='btn' id='moreContactsButton' title='Tilf&oslash;j specifikke kontaktpersoner'><i class='icon-chevron-down' id='moreDown'></i><i class='icon-chevron-up' id='moreUp'></i></a>
                        </div>
                    </div>

                    <div class='collapse' id='moreContacts'>
                        <div class="control-group">
                            <label class="control-label" for="contact_technique">- teknik</label>
                            <div class="controls">
                                <select id="contact_technique" name="contact_technique">
                                    <?php echo $this->getPossibleContacts($this->contact_technique);?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="contact_pr">- PR</label>
                            <div class="controls">
                                <select id="contact_pr" name="contact_pr">
                                    <?php echo $this->getPossibleContacts($this->contact_pr);?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="contact_tickets">- billetsalg</label>
                            <div class="controls">
                                <select id="contact_tickets" name="contact_tickets">
                                    <?php echo $this->getPossibleContacts($this->contact_tickets);?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="date">Dato / Tidspunkt:</label>
                        <div class="controls">
                            <span name="date" class="uneditable-input input-small" type="text" ><?php echo $this->date;?> </span>
                            <span name="time" type='text' class='uneditable-input input-mini'><?php echo $this->time;?> </span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="schedule">Tidsplan:</label>
                        <div class="controls">
                            <textarea name="schedule" rows='10' style='max-width:250px;max-height:300px;'><?php echo $this->schedule; //TODO: REMOVE STYLE?></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Synlighed:</label>
                        <div class="controls">
                        <span class='uneditable-input input-mini'> <?php echo $this->visibility;?>  </span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="postercount">Antal plakater:</label>
                        <div class="controls">
                            <span class='uneditable-input input-mini' id="postercount" name="postercount"> <?php echo $this->postercount;?>  </span>
                        </div>
                    </div>

                    <hr/>

                    <div class="control-group">
                        <label class="control-label" for="honorar">Honorar:</label>
                        <div class="controls">
                            <div class="input-append">
                                <span class="input-small uneditable-input" id="honorar" name="honorarium"><?php echo $this->honorarium;?></span>
                                <span class="add-on">DKK eks. moms</span>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="provision">Provision:</label>
                        <div class="controls">
                        <div class="input-append">
                        <span class="uneditable-input input-small" id="provision" name="provision"><?php echo $this->provision;?></span>
                        <span class="add-on">DKK eks. moms</span>
                        </div>
                        </div>
                    </div>

                    

                    <hr />
					<div class="control-group">
                        <label class="control-label" for="pricemodel">Prismodel:</label>
                        <div class="controls">
                        <span class="uneditable-input input-small"> <?php echo ($this->pricemodel)?> </span>
                        </div>
                    </div>
                    <p class='pull-right' id='total_price'>0,00</p>
                    <p>Samlet pris</p>
                    <p class='pull-right' id='total_moms'>0,00</p>
                    <p>Moms udg&oslash;r</p>
<!--
                    <b>Handlinger</b><br>
                    <a class='span1 btn' style='text-align:center;'>
                        <img src='./img/pdficon_large.png'>
                        <p>Kontrakt<br>&nbsp;</p>
                    </a> 
                    <a class='span1 btn' style='text-align:center;'>
                        <img src='./img/pdficon_large.png'>
                        <p>Kontrakt underskrevet</p>
                    </a>

                    <a class='span1 btn' style='text-align:center;'>
                        <img src='./img/pdficon_large.png'>
                        <p>Kontrakt endelig</p>
                    </a>
                    -->
	                    <div class="control-group">
                        <div class="controls">
                        <?php global $currentuser; if ($currentuser->type == User::USERTYPE_FMK) {?>
                            <a href="./edit/<?php echo $this->eventid;?>" class="btn btn-large" style="float:right">Rediger</a>
                            <?php }?>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<script src="js/event.js"></script>
<script type='text/javascript'>
	calcPrice();
</script>
<?php
    }
}

?>