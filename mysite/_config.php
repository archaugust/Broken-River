<?php

global $project;
$project = 'mysite';

global $databaseConfig;
$databaseConfig = array(
	'type' => 'MySQLDatabase',
	'server' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'samspi30294com37928_testspinifex',
	'path' => ''
);

// Set the site locale
i18n::set_locale('en_US');

// custom menu links
// LeftAndMain::add_extension('CustomLeftAndMain');
// LeftAndMain::require_css('themes/custom/css/leftandmain.css');

// slugify strings
Object::add_extension('StringField', 'StringFieldExtension');
Security::setDefaultAdmin('admin', 'password');