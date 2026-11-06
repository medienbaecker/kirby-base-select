<?php

use Kirby\Cms\App as Kirby;
use Medienbaecker\Select\OptionsApi;
use Medienbaecker\Select\OptionsQuery;
use Medienbaecker\Select\SelectField;

load([
	OptionsApi::class   => 'lib/OptionsApi.php',
	OptionsQuery::class => 'lib/OptionsQuery.php',
	SelectField::class  => 'lib/SelectField.php'
], __DIR__);

Kirby::plugin('medienbaecker/select', [
	'fields' => [
		'select' => SelectField::class
	]
]);
