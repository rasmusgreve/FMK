<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>FMK Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-datepicker.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#">FMK</a>
          <div class="nav-collapse">
            <ul class="nav">
              <!--<li class="active"><a href="#">Arrangementer</a></li>
              <li><a href="#about">Kontakter</a></li>-->
              
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

	<div class="container">
	 <div class='row'>
	  <div class='span8'>
	  
	  <form class="well form-horizontal" method="get">
	  <fieldset>
	   <legend>Koncert</legend>
	   
		<div class="control-group">
         <label class="control-label" for="input01">Kunstner</label>
         <div class="controls">
          <input type="text" id='input01' name='artist' data-provide="typeahead" data-items="4" data-source='["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]'>
		  <p class='help-block'>For at skifte kunstner eller venue skal der oprettes et nyt arrangement</p>
		 </div>
        </div>
		
		<div class="control-group">
         <label class="control-label" for="input01">Venue</label>
         <div class="controls">
          <input type="text" id='input01' name='artist' data-provide="typeahead" data-items="4" data-source='["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]'>
         </div>
        </div>
		
		<div class="control-group">
         <label class="control-label" for="input01">Kontaktperson</label>
         <div class="controls">
          <select>
		   <option>V&aelig;lg kontaktperson</option>
		   <option>Emil Nygaard - 12345678</option>
	       <option>Rasmus Greve - 21669979</option>
	      </select>
		  <a href='#' onclick='	$("#moreContacts").collapse("toggle");
								$("#moreDown").toggle();
								$("#moreUp").toggle();
		  ' class='btn' id='moreContactsButton' title='Tilf&oslash;j specifikke kontaktpersoner'><i class='icon-chevron-down' id='moreDown'></i><i class='icon-chevron-up' id='moreUp'></i></a>
         </div>
        </div>
		
		<div class='collapse' id='moreContacts'>
		 <div class="control-group">
          <label class="control-label" for="input01">- teknik</label>
          <div class="controls">
           <select>
		    <option>V&aelig;lg kontaktperson</option>
		    <option>Emil Nygaard - 12345678</option>
	        <option>Rasmus Greve - 21669979</option>
	       </select>
          </div>
         </div>
		 
		 <div class="control-group">
          <label class="control-label" for="input01">- PR</label>
          <div class="controls">
           <select>
		    <option>V&aelig;lg kontaktperson</option>
		    <option>Emil Nygaard - 12345678</option>
	        <option>Rasmus Greve - 21669979</option>
	       </select>
          </div>
         </div>
		 
		 <div class="control-group">
          <label class="control-label" for="input01">- billetsalg</label>
          <div class="controls">
           <select>
		    <option>V&aelig;lg kontaktperson</option>
		    <option>Emil Nygaard - 12345678</option>
	        <option>Rasmus Greve - 21669979</option>
	       </select>
          </div>
         </div>
		</div>
		
		<div class="control-group">
         <label class="control-label" for="input01">Tidspunkt</label>
         <div class="controls">
          <input data-datepicker="datepicker" class="input-small" type="text" value="<?php echo date("Y-m-d");?>" />
		  <input type='text' class='input-mini' placeholder='Tid' value='18:00'/>
         </div>
        </div>
		
		<div class="control-group">
         <label class="control-label" for="input01">Tidsplan</label>
         <div class="controls">
          <textarea rows='10' style='max-width:250px;max-height:300px;'></textarea>
         </div>
        </div>
		
		<div class="control-group">
         <label class="control-label" for="visible">Synlighed</label>
         <div class="controls">
          <label class="radio">
           <input type="radio" name="visible" id="visible" value="1" checked>
           Announced
          </label>
		  <label class="radio">
           <input type="radio" name="visible" id="visible" value="2">
           TBA
          </label>
		  <label class="radio">
           <input type="radio" name="visible" id="visible" value="3">
           Reservation
          </label>
         </div>
        </div>
		
		<div class="control-group">
         <label class="control-label" for="input01">Antal plakater</label>
         <div class="controls">
          <input type='number' class='input-mini' max='9999' min='0' value='5' name='postercount'>
         </div>
        </div>
		
		<hr/> <!-- $ -->
		
		<div class="control-group">
         <label class="control-label" for="input01">Honorar</label>
         <div class="controls">
          <div class="input-append">
		   <input class="input-small" id="honorar" size="16" type="text" onblur='calcPrice();' onkeyup='calcPrice();'>
		   <span class="add-on">DKK eks. moms</span>
		  </div>
         </div>
        </div>
		
		<div class="control-group">
         <label class="control-label" for="input01">Provision</label>
         <div class="controls">
          <div class="input-append">
		   <input class="input-small" id="provision" size="16" type="text" onblur='calcPrice();' onkeyup='calcPrice();' >
		   <span class="add-on">DKK eks. moms</span>
		  </div>
         </div>
        </div>
		
		<div class="control-group">
         <label class="control-label" for="input01">Prismodel</label>
         <div class="controls">
          <label class="radio">
           <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
           Flat fee
          </label>
          <label class="radio">
           <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
           Bonus
          </label>
         </div>
        </div>
		
		
		<hr /> <!-- $ -->
		
		
		<p class='pull-right' id='total_price'>0,00</p>
		<p>Samlet pris</p>
		<p class='pull-right' id='total_moms'>0,00</p>
		<p>Moms udg&oslash;r</p>
		
		<hr /> <!-- Actions -->
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
		
       </fieldset>
	</form>
	  </div>
	 </div>
	  
	 </div>
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
	<script>
		$('#moreContacts').collapse('hide');
		$('#moreUp').hide();
		$('#moreContactsButton').tooltip();
			
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
					out = "." + out;
			}
			if (pieces.length > 1)
				if (pieces[1].length == 1)
					return out + "," + pieces[1] + "0";
				else
					return out + "," + pieces[1];
			else
				return out + ",00";
		}
	</script>
  </body>
</html>
