<?php

use Kirby\Cms\App as Kirby;
use Medienbaecker\BaseSelect\OptionsApi;
use Medienbaecker\BaseSelect\OptionsQuery;
use Medienbaecker\BaseSelect\SelectField;

load([
	OptionsApi::class   => 'lib/OptionsApi.php',
	OptionsQuery::class => 'lib/OptionsQuery.php',
	SelectField::class  => 'lib/SelectField.php'
], __DIR__);

Kirby::plugin('medienbaecker/base-select', [
	'fields' => [
		'select' => SelectField::class
	]
]);
