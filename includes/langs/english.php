<?php

function langs ($phrase) {

	static $langs = array(

		// navbar links
		'home-admin'  => 'Home',
		'session'     => 'categories',
		'items'       => 'Items',
		'statics'     => 'Statics',
		'comments'    => 'Comments',
		'members'     => 'Members',
		'logs'        => 'Logs',


		//drowpdownlinks
		'edit'       => 'Edit',
		'setting'    => 'Setting',
		'logout'     => 'Logout'			


	);
	return $langs[$phrase];
}

