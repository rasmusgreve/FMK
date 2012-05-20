<?php

class EventPage implements iPage
{
    private $date, $time, $visibility, $schedule, $postercount, $honorarium, $provision, $pricemodel, $contact, $contact_technique, $contact_pr, $contact_tickets;
    private $eventid = -1;
    private $artistname, $venuename;
    
    public function consumePost($command, $params, $user)
    {
        if (count($params) > 0 && is_numeric($params[0]))
            $this->eventid = $params[0];
        
        $eventquery = mysql_query("SELECT e.*, a.`name` as artistname, v.`name` as venuename FROM `event` e, `artist` a, `venue` v WHERE e.`artist` = a.`id` AND e.`venue` = v.`id` LIMIT 1;");
        if (mysql_num_rows($eventquery) == 0)
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
        ?>
<div class="container">
    <div class='row'>
        <div class=''>
            <form class="well form-horizontal" method="post">
                <input type="hidden" name="id" value="<?php echo $this->eventid; ?>">
                <fieldset>
                    <legend>Koncert</legend>
                    <div class="control-group">
                        <label class="control-label" for="artist">Kunstner</label>
                        <div class="controls">
                            <span class="uneditable-input"><?php echo $this->artistname;?></span>
                            <a href="./newevent/3" class="">Skift kunstner</a>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="venue">Venue</label>
                        <div class="controls">
                            <span class="uneditable-input"><?php echo $this->venuename;?></span>
                            <a href="./newevent/3" class="">Skift venue</a>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="contact">Kontaktperson</label>
                        <div class="controls">
                            <select id="contact" name="contact">
                                <option value="1">V&aelig;lg kontaktperson</option>
                                <option value="2">Emil Nygaard - 12345678</option>
                                <option value="3">Rasmus Greve - 21669979</option>
                            </select>
                            <a href='./event#' onclick='$("#moreContacts").collapse("toggle");$("#moreDown").toggle();$("#moreUp").toggle();return false;' class='btn' id='moreContactsButton' title='Tilf&oslash;j specifikke kontaktpersoner'><i class='icon-chevron-down' id='moreDown'></i><i class='icon-chevron-up' id='moreUp'></i></a>
                        </div>
                    </div>

                    <div class='collapse' id='moreContacts'>
                        <div class="control-group">
                            <label class="control-label" for="contact_technique">- teknik</label>
                            <div class="controls">
                                <select id="contact_technique" name="contact_technique">
                                    <option>V&aelig;lg kontaktperson</option>
                                    <option>Emil Nygaard - 12345678</option>
                                    <option>Rasmus Greve - 21669979</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="contact_pr">- PR</label>
                            <div class="controls">
                                <select id="contact_pr" name="contact_pr">
                                    <option>V&aelig;lg kontaktperson</option>
                                    <option>Emil Nygaard - 12345678</option>
                                    <option>Rasmus Greve - 21669979</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="contact_tickets">- billetsalg</label>
                            <div class="controls">
                                <select id="contact_tickets" name="contact_tickets">
                                    <option>V&aelig;lg kontaktperson</option>
                                    <option>Emil Nygaard - 12345678</option>
                                    <option>Rasmus Greve - 21669979</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="date">Tidspunkt</label>
                        <div class="controls">
                            <input name="date" data-datepicker="datepicker" class="input-small" type="text" value="<?php echo $this->date;?>" />
                            <input name="time" type='text' class='input-mini' placeholder='Tid' value="<?php echo $this->time;?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="schedule">Tidsplan</label>
                        <div class="controls">
                            <textarea name="schedule" rows='10' style='max-width:250px;max-height:300px;'><?php echo $this->schedule; //TODO: REMOVE STYLE?></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Synlighed</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio"  name="visibility" value="public" <?php echo ($this->visibility == "public") ? "checked":"";?>> Announced
                            </label>
                            <label class="radio">
                                <input type="radio" name="visibility" value="tba" <?php echo ($this->visibility == "tba") ? "checked":"";?>> TBA
                            </label>
                            <label class="radio">
                                <input type="radio" name="visibility" value="reservation" <?php echo ($this->visibility == "reservation") ? "checked":"";?>> Reservation
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="postercount">Antal plakater</label>
                        <div class="controls">
                            <input type='number' class='input-mini' max='9999' min='0' id="postercount" name="postercount" value="<?php echo $this->postercount;?>" name='postercount'>
                        </div>
                    </div>

                    <hr/>

                    <div class="control-group">
                        <label class="control-label" for="honorar">Honorar</label>
                        <div class="controls">
                            <div class="input-append">
                                <input class="input-small" id="honorar" size="16" type="text" name="honorarium" onblur='calcPrice();' onkeyup='calcPrice();' value="<?php echo $this->honorarium;?>">
                                <span class="add-on">DKK eks. moms</span>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="provision">Provision</label>
                        <div class="controls">
                        <div class="input-append">
                        <input class="input-small" id="provision" size="16" type="text" name="provision" onblur='calcPrice();' onkeyup='calcPrice();' value="<?php echo $this->provision;?>">
                        <span class="add-on">DKK eks. moms</span>
                        </div>
                        </div>
                    </div>

                    

                    <hr />
<div class="control-group">
                        <label class="control-label" for="pricemodel">Prismodel</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="pricemodel" id="pricemodel" value="flatfee" <?php echo ($this->pricemodel == "flatfee") ? "checked":"";?>> Flat fee
                            </label>
                            <label class="radio">
                                <input type="radio" name="pricemodel" value="bonus" <?php echo ($this->pricemodel == "flatfee") ? "bonus":"";?>> Bonus
                            </label>
                        </div>
                    </div>
                    <p class='pull-right' id='total_price'>0,00</p>
                    <p>Samlet pris</p>
                    <p class='pull-right' id='total_moms'>0,00</p>
                    <p>Moms udg&oslash;r</p>

                    <hr />
<!--
                    <b>Handlinger</b><br>
                    <a class='span1 btn' style='text-align:center;'>
                        <img src='./img/pdficon_large.png'>
                        <p>Kontrakt</p>
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
                            <input type="submit" value="Gem ændringer" class="btn btn-primary btn-large">
                            <a href="./" class="btn btn-large">Annuller</a>
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