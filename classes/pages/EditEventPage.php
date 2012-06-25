<?php

class EditEventPage implements iPage
{
	private $event;
	private $edit_event_errors = array();

	private function getVenues($selected_venue)
	{
		$out = "";
		$q = mysql_query("SELECT * FROM `venue` ORDER BY `name` ASC");
		while ($res = mysql_fetch_assoc($q))
		{
			if ($res['id'] == $selected_venue)
				$out .= "<option value='{$res['id']}' selected>{$res['name']}</option>";
			else
				$out .= "<option value='{$res['id']}'>{$res['name']}</option>";
		}
		return $out;
	}
	
	private function getPossibleContacts($possible_contacts, $selected_id)
	{
		$possible_contacts_as_options = "<option value='0'>V&aelig;lg kontaktperson</option>";
		foreach ($possible_contacts as $contact)
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
		if (isset($_POST['delete']))
		{
			mysql_query("INSERT INTO `deleted_event` (SELECT * FROM `event` WHERE `id` = '{$this->eventid}');");
			mysql_query("UPDATE `deleted_event` SET `creationtoken` = '".time()."' WHERE `id` = '{$this->eventid}';"); //Save deletion time
			mysql_query("DELETE FROM `event` WHERE `id` = '{$this->eventid}' LIMIT 1;");
			return "./"; //TODO: Informer brugeren om hvad der er sket
		}
		
        if (!isset($_POST["submit"]))
		{
			if (count($params) == 0 || !ctype_digit($params[0]))
			{
				//Todo; errorhandling
			}
			$this->event = Event::FromDB($params[0]);
            return false;
		}
		
		$errors = Event::ValidateForm();
		$this->event = Event::FromForm();
		if (count($errors) == 0)
		{
			$this->event->Save();
		}
        else
        {
            $this->edit_event_errors = $errors;
        }
		return false;
    }
	
	private function convertErrors($errors)
	{
		$msgs = array(
			'event_id' => 'Det angivne koncert ID (kan ikke rettes - kontakt os på TODO: mail her)',
			'date' => 'Datofeltet. Det korrekte format er &Aring;&Aring;&Aring;&Aring;/MM/DD f.eks. ' . date('Y/m/d'),
			'time' => 'Tidsfeltet. Det korrekte format er TT:MM f.eks. ' . date('H:i'),
			'visibility' => 'Synlighed. Der skal v&aelig;lges en mulighed',
			'schedule' => 'Tidsplan. (Det er normalt umuligt at f&aring; denne fejl - kontakt os på TODO: mail her)',
			'postercount' => 'Plakatantal. Skal angives som et heltal',
			'honorarium' => 'Honorar. Skal angives som et heltal',
			'provision' => 'Provision. Skal angives som et heltal',
			'pricemodel' => 'Prismodel. Der skal v&aelig;lges en mulighed',
			'contact' => 'Kontaktperson. (Det er normalt umuligt at f&aring; denne fejl - kontakt os på TODO: mail her) ',
			'contact_technique' => '',
			'contact_pr' => '',
			'contact_tickets' => '',
			'artist' => 'Kunstner. Der skal angives en gyldig kunstner',
			'venue' => 'Venue. Der skal angives et gyldigt venue'
		);
		$out = "<ul>";
		
		foreach ($errors as $key => $value)
		{
			$out .= (isset($msgs[$key])) ? '<li>'.$msgs[$key].'</li>' : '';
		}
		
		$out .= "</ul>";
		return $out;
	}
	
	private function GetErrorClass($input)
	{
		if (!isset($this->edit_event_errors[$input])) return;
		echo 'error';
	}
	private function GetErrorMessage($input)
	{
		$error_messages = array(
			'event_id' => 'Det angivne koncert ID (kan ikke rettes - kontakt os på TODO: mail her)',
			'date' => 'Datofeltet. Det korrekte format er &Aring;&Aring;&Aring;&Aring;/MM/DD f.eks. ' . date('Y/m/d'),
			'time' => 'Tidsfeltet. Det korrekte format er TT:MM f.eks. ' . date('H:i'),
			'visibility' => 'Synlighed. Der skal v&aelig;lges en mulighed',
			'schedule' => 'Tidsplan. (Det er normalt umuligt at f&aring; denne fejl - kontakt os på TODO: mail her)',
			'postercount' => 'Plakatantal. Skal angives som et heltal',
			'honorarium' => 'Honorar. Skal angives som et heltal',
			'provision' => 'Provision. Skal angives som et heltal',
			'pricemodel' => 'Prismodel. Der skal v&aelig;lges en mulighed',
			'contact' => 'Kontaktperson. (Det er normalt umuligt at f&aring; denne fejl - kontakt os på TODO: mail her)',
			'contact_technique' => 'Kontaktperson. (Det er normalt umuligt at f&aring; denne fejl - kontakt os på TODO: mail her)',
			'contact_pr' => 'Kontaktperson. (Det er normalt umuligt at f&aring; denne fejl - kontakt os på TODO: mail her)',
			'contact_tickets' => 'Kontaktperson. (Det er normalt umuligt at f&aring; denne fejl - kontakt os på TODO: mail her)',
			'artist' => 'Der skal angives en gyldig kunstner',
			'venue' => 'Venue. Der skal angives et gyldigt venue'
		);
	
		if (!isset($this->edit_event_errors[$input])) return;
		echo '<span class="help-inline"><i class="icon-remove"></i> '.$error_messages[$input].'</span>';
	}
    
    public function show($command, $params, $user)
    {				
		$artist_q = mysql_query("SELECT `name` FROM `artist` WHERE `id` = '{$this->event->artist}' LIMIT 1;");
		$venue_q = mysql_query("SELECT `name` FROM `venue` WHERE `id` = '{$this->event->venue}' LIMIT 1;");
		$artistname = (mysql_num_rows($artist_q) == 1) ? mysql_result($artist_q,0,0) : '';
		$venuename = (mysql_num_rows($venue_q) == 1) ? mysql_result($venue_q,0,0) : '';
		
		$possible_contacts = array();
		$q = mysql_query("SELECT * FROM `contact` WHERE `venue` = '{$this->event->venue}' ORDER BY `name` DESC;");
		
		while ($res = mysql_fetch_assoc($q))
		{
			$possible_contacts[] = array('id' => $res['id'], 'name' => $res['name'] . ' - ' . $res['phone']);
		}
		
		
        ?>
<div class="container">
    <div class='row'>
        <div class=''>
            <form class="well form-horizontal" method="post" autocomplete="off">
				<?php
				if (count($this->edit_event_errors) > 0)
				{
					
					?>
					<div class="alert alert-error">
					  <button class="close" data-dismiss="alert">×</button>
					  <strong>Fejl!</strong> Der er fejl i nogle af de indtastede data. Kontroler følgende punkter:<br/>
					  <?php echo $this->convertErrors($this->edit_event_errors); ?>
					</div>
					<?php
					
				}
				?>
                <input type="hidden" name="event_id" value="<?php echo $this->event->id; ?>">
                <fieldset>
                    <legend>Rediger koncert</legend>
					
                    <div class="control-group <?php $this->GetErrorClass('artist');?>">
                        <label class="control-label" for="artist">Kunstner</label>
                        <div class="controls">
                            <input value='artistname TODO'/>
							<?php $this->GetErrorMessage('artist');?>
						</div>
                    </div>
                    <div class="control-group <?php $this->GetErrorClass('venue');?>">
                        <label class="control-label" for="venue">Venue</label>
                        <div class="controls">
							<select id='venue' name='venue' onchange='ReloadContacts();' title='Bemærk! Ved skift af venue vil valgte kontaktpersoner blive nulstillet'>
								<?php echo $this->getVenues($this->event->venue);?> 
							</select> 
							<?php $this->GetErrorMessage('venue');?>
                        </div>
                    </div>
					<hr/>
										
                    <div class="control-group <?php $this->GetErrorClass('contact');?>">
                        <label class="control-label" for="contact">Kontaktperson</label>
                        <div class="controls">
                            <select id="contact" name="contact">
								<?php echo $this->getPossibleContacts($possible_contacts, $this->event->contact);?>
                            </select>
                            <a href='./event#' onclick='$("#moreContacts").collapse("toggle");$("#moreDown").toggle();$("#moreUp").toggle();return false;' class='btn' id='moreContactsButton' title='Tilf&oslash;j specifikke kontaktpersoner'><i class='icon-chevron-down' id='moreDown'></i><i class='icon-chevron-up' id='moreUp'></i></a>
							<?php $this->GetErrorMessage('contact');?>
                        </div>
                    </div>

                    <div class='collapse' id='moreContacts'>
                        <div class="control-group <?php $this->GetErrorClass('contact_technique');?>">
                            <label class="control-label" for="contact_technique">- teknik</label>
                            <div class="controls">
                                <select id="contact_technique" name="contact_technique">
                                    <?php echo $this->getPossibleContacts($possible_contacts, $this->event->contact_technique);?>
                                </select>
								<?php $this->GetErrorMessage('contact_technique');?>
                            </div>
                        </div>

                        <div class="control-group <?php $this->GetErrorClass('contact_pr');?>">
                            <label class="control-label" for="contact_pr">- PR</label>
                            <div class="controls">
                                <select id="contact_pr" name="contact_pr">
                                    <?php echo $this->getPossibleContacts($possible_contacts, $this->event->contact_pr);?>
                                </select>
								<?php $this->GetErrorMessage('contact_pr');?>
                            </div>
                        </div>

                        <div class="control-group <?php $this->GetErrorClass('contact_tickets');?>">
                            <label class="control-label" for="contact_tickets">- billetsalg</label>
                            <div class="controls">
                                <select id="contact_tickets" name="contact_tickets">
                                    <?php echo $this->getPossibleContacts($possible_contacts, $this->event->contact_tickets);?>
                                </select>
								<?php $this->GetErrorMessage('contact_tickets');?>
                            </div>
                        </div>
                    </div>

                    <div class="control-group <?php $this->GetErrorClass('date');?> <?php $this->GetErrorClass('time');?>">
                        <label class="control-label" for="date">Dato / Tidspunkt</label>
                        <div class="controls">
                            <input name="date" data-datepicker="datepicker" data-date-format="yyy/mm/dd" class="input-small" type="text" value="<?php echo $this->event->date;?>" />
                            <input name="time" type='text' class='input-mini' placeholder='Tid' value="<?php echo $this->event->time;?>" /> F.eks. 17:45
							<?php $this->GetErrorMessage('date');?> <?php $this->GetErrorMessage('time');?>
                        </div>
                    </div>

                    <div class="control-group <?php $this->GetErrorClass('schedule');?>">
                        <label class="control-label" for="schedule">Tidsplan</label>
                        <div class="controls">
                            <textarea name="schedule" rows='10' style='max-width:250px;max-height:300px;'><?php echo $this->event->schedule; //TODO: REMOVE STYLE?></textarea>
							<?php $this->GetErrorMessage('schedule');?>
                        </div>
                    </div>

                    <div class="control-group <?php $this->GetErrorClass('visibility');?>">
                        <label class="control-label">Synlighed</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio"  name="visibility" value="public" <?php echo ($this->event->visibility == "public") ? "checked":"";?>> Announced
                            </label>
                            <label class="radio">
                                <input type="radio" name="visibility" value="tba" <?php echo ($this->event->visibility == "tba") ? "checked":"";?>> TBA
                            </label>
                            <label class="radio">
                                <input type="radio" name="visibility" value="reservation" <?php echo ($this->event->visibility == "reservation") ? "checked":"";?>> Reservation
                            </label>
							<?php $this->GetErrorMessage('visibility');?>
                        </div>
                    </div>

                    <div class="control-group <?php $this->GetErrorClass('postercount');?>">
                        <label class="control-label" for="postercount">Antal plakater</label>
                        <div class="controls">
                            <input type='number' class='input-mini' max='9999' min='0' id="postercount" name="postercount" value="<?php echo $this->event->postercount;?>" name='postercount'>
							<?php $this->GetErrorMessage('postercount');?>
                        </div>
                    </div>

                    <hr/>

                    <div class="control-group <?php $this->GetErrorClass('honorarium');?>">
                        <label class="control-label" for="honorar">Honorar</label>
                        <div class="controls">
                            <div class="input-append">
                                <input class="input-small" id="honorar" size="16" type="text" name="honorarium" onblur='calcPrice();' onkeyup='calcPrice();' value="<?php echo $this->event->honorarium;?>">
                                <span class="add-on">DKK eks. moms</span>
								<?php $this->GetErrorMessage('honorarium');?>
                            </div>
                        </div>
                    </div>

                    <div class="control-group <?php $this->GetErrorClass('provision');?>">
                        <label class="control-label" for="provision">Provision</label>
                        <div class="controls">
                        <div class="input-append">
                        <input class="input-small" id="provision" size="16" type="text" name="provision" onblur='calcPrice();' onkeyup='calcPrice();' value="<?php echo $this->event->provision;?>">
                        <span class="add-on">DKK eks. moms</span>
						<?php $this->GetErrorMessage('provision');?>
                        </div>
                        </div>
                    </div>
					
					<div class="control-group <?php $this->GetErrorClass('pricemodel');?>">
                        <label class="control-label" for="pricemodel">Prismodel</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="pricemodel" value="flatfee" <?php echo ($this->event->pricemodel == "flatfee") ? "checked":"";?>> Flat fee
                            </label>
                            <label class="radio">
                                <input type="radio" name="pricemodel" value="bonus" <?php echo ($this->event->pricemodel == "bonus") ? "checked":"";?>> Bonus
                            </label>
							<?php $this->GetErrorMessage('pricemodel');?>
                        </div>
                    </div>
                    <p class='pull-right' id='total_price'>0,00</p>
                    <p>Samlet pris</p>
                    <p class='pull-right' id='total_moms'>0,00</p>
                    <p>Moms udg&oslash;r</p>
					<hr/>
                    <div class="control-group">
                        <div class="controls">
                            <input type="submit" value="Gem ændringer" name='submit' class="btn btn-primary btn-large">
                            <a href="./event/<?php echo $this->event->id;?>" class="btn btn-large">Annuller</a>
                            <input style='float:right;' type="submit" name='delete' onclick='return confirm("Er du sikker på at du vil slette arrangement med <?php echo $artistname;?> på <?php echo $venuename;?>? \nDenne handling kan IKKE fortrydes!")' value="Slet arrangement" class="btn btn-danger btn-large">
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<script src="./js/event.js"></script>
<script type='text/javascript'>
	calcPrice();
</script>
<?php
	unset($_SESSION['edit_event_errors']);
    }
}

?>