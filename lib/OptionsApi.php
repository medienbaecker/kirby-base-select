<?php

namespace Medienbaecker\Select;

use Kirby\Cms\ModelWithContent;
use Kirby\Cms\Nest;
use Kirby\Content\Field;
use Kirby\Option\Options;
use Kirby\Option\OptionsApi as CoreOptionsApi;
use Kirby\Query\Query;

class OptionsApi extends CoreOptionsApi
{
	/**
	 * API data of each resolved item, keyed by the option value
	 */
	public array $items = [];

	protected array|null $data = null;

	public function resolve(ModelWithContent $model, bool $safeMode = true): Options
	{
		$options = parent::resolve($model, $safeMode);
		$data    = Query::factory($this->query)->resolve(Nest::create($this->data));

		foreach ($data as $key => $item) {
			if (is_string($item) === true) {
				$item = new Field(null, $key, $item);
			}

			$this->items[$model->toString($this->value, ['item' => $item])] = ['item' => $item];
		}

		return $options;
	}

	public function load(ModelWithContent $model): array|null
	{
		return $this->data = parent::load($model);
	}
}
