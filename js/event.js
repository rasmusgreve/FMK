$('#moreContacts').collapse('hide');
$('#moreUp').hide();
$('#moreContactsButton').tooltip();
$('#venue').tooltip();

function calcPrice()
{
    h = parseInt($('#honorar').val()) || 0;
    p = parseInt($('#provision').val()) || 0;
    //$('#honorar').val($('#honorar').val().replace(/[,\.\-]/i,""));
    //$('#provision').val($('#provision').val().replace(/[,\.\-]/i,""));
    $('#total_price').html(makeMoneyNice(((h + p)*1.25)));
    $('#total_moms').html(makeMoneyNice(((h + p)*0.25)));
    //return h+p;
}

function makeMoneyNice(money)
{
    all = String(money);
    pieces = all.split(".");
    str = pieces[0];
    out = "";
    for (i = str.length-1; i >= 0; i--)
    {
        out = str[i] + out;
        if (((str.length-1)-i)%3==2 && i>0)
        {
            out = "." + out;
        }
    }
    if (pieces.length > 1)
    {
        if (pieces[1].length == 1)
        {
            return out + "," + pieces[1] + "0";
        }
        else
        {
            return out + "," + pieces[1];
        }
    }
    else
    {
        return out + ",00";
    }
}

function ReloadContacts()
	{
		var venue = $('#venue').val();
		$('#contact').load('./ajax/contacts.php?venue=' + venue + '&type=contact');
		$('#contact_technique').load('./ajax/contacts.php?venue=' + venue + '&type=contact_technique');
		$('#contact_pr').load('./ajax/contacts.php?venue=' + venue + '&type=contact_pr');
		$('#contact_tickets').load('./ajax/contacts.php?venue=' + venue + '&type=contact_tickets');
	}