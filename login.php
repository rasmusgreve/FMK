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
	  <div class='span5 offset3'>
	  <h1>Log ind</h1>
	  <form class="well" method="post">
	  <label>Brugernavn</label>
	  <input type="text" class="span3" name="username">
	  <a class="help-inline" href='#'>Glemt brugernavn?</a>
	  <label>Adgangskode</label>
	  <input type="password" class="span3" name="password">
	  <a class="help-inline" href='#'>Glemt adgangskode?</a>
	  <label class="checkbox">
		<input type="checkbox"> Husk mig p&aring; denne computer
	  </label>
	  <button type="submit" class="btn">Log ind</button>
	</form>
	  </div>
	 </div>
      
	  	  
	  
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

  </body>
</html>
