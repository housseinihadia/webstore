<?php

function langs ($phrase) {

	static $langs = array(

		'name' => 'هشام ',

		'faculty' => 'علوم الحاسب'

	);

	return $langs[$phrase];
}