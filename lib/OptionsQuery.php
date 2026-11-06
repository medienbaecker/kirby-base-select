<?php

namespace Medienbaecker\Select;

use Kirby\Cms\ModelWithContent;
use Kirby\Option\Options;
use Kirby\Option\OptionsQuery as CoreOptionsQuery;

class OptionsQuery extends CoreOptionsQuery
{
	/**
	 * Query data of each resolved item, keyed by the option value
	 */
	public array $items = [];

	protected ModelWithContent $model;

	protected function itemToDefaults(array|object $item): array
	{
		$defaults = parent::itemToDefaults($item);
		$data     = ['item' => $item, $defaults[0] => $item];

		$this->items[$this->model->toString($this->value ?? $defaults[2], $data)] = $data;

		return $defaults;
	}

	public function resolve(ModelWithContent $model, bool $safeMode = true): Options
	{
		$this->model = $model;

		return parent::resolve($model, $safeMode);
	}
}
