<?php
$pages = array(
    array('title' => 'Log ind',         'command' => '_ANY_',   'usertype' => 'none',               'page' => new LoginPage()),
    array('title' => 'Forside',         'command' => '',        'usertype' => 'fmk/artist/venue',   'page' => new EventOverviewPage()),
    array('title' => 'Ny koncert',      'command' => 'newevent','usertype' => 'fmk',                'page' => new CreateEventPage()),
    array('title' => 'Indstillinger',   'command' => 'settings','usertype' => 'fmk/artist/venue',   'page' => new SettingsPage()),
    array('title' => 'Log ud',          'command' => 'logout',  'usertype' => 'fmk/artist/venue',   'page' => new LogoutPage()),
    array('title' => '',				'command' => 'edit',    'usertype' => 'fmk',				'page' => new EditEventPage()),
	array('title' => '',				'command' => 'event',   'usertype' => 'fmk/artist/venue',   'page' => new ViewEventPage())
);


?>