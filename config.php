<?php

$databases = array(
    array('localhost','root','','fmk'),
	array('nas.emilnygaard.com','fmk','fmk','fmk'),
    array('mydb13.surftown.dk','rasmu11_fmk','fmkode','rasmu11_fmk')
);
$database = $databases[1];

mysql_connect($database[0],$database[1],$database[2]);
mysql_select_db($database[3]);


//ANY
$pages = array(
    array('title' => 'Log ind',         'command' => '_ANY_',   'usertype' => 'none',                'page' => new LoginPage()),
    array('title' => 'Forside',         'command' => '',        'usertype' => 'fmk/artist/venue',    'page' => new OverviewPage()),
    array('title' => 'Ny koncert',      'command' => 'newevent','usertype' => 'fmk',                 'page' => new CreateEventPage()),
    array('title' => 'Koncerter',       'command' => 'event',   'usertype' => 'fmk/artist/venue',    'page' => new EventPage()),
    array('title' => 'Indstillinger',   'command' => 'settings','usertype' => 'fmk/artist/venue',    'page' => new SettingsPage()),
    array('title' => 'Log ud',          'command' => 'logout',  'usertype' => 'fmk/artist/venue',    'page' => new LogoutPage()),
    array('title' => 'Se koncert',      'command' => 'view',    'usertype' => 'fmk/artist/venue',    'page' => new ViewEventPage())
);


?>