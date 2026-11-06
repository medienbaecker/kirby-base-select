<?php

namespace Medienbaecker\BaseSelect;

use Kirby\Cms\ModelWithContent;
use Kirby\Form\Field\SelectField as CoreSelectField;
use Kirby\Form\FieldOptions;
use Kirby\Option\Options;
use Kirby\Reflection\Attributes\Prop;
use Kirby\Toolkit\Str;
use Throwable;

class SelectField extends CoreSelectField
{
	protected const EXTRAS = ['font', 'image', 'theme'];

	/**
	 * Icon shown next to the placeholder
	 */
	#[Prop]
	protected string|null $placeholderIcon = null;

	protected function fetchOptions(): array
	{
		$props   = FieldOptions::polyfill(['options' => $this->options ?? []]);
		$options = $props['options'];
		$extras  = [];

		if (($options['type'] ?? null) === 'array') {
			foreach ($options['options'] as $key => $option) {
				if (is_array($option) === true && array_key_exists('value', $option) === true) {
					$extras[$option['value']] = $this->extras($option);

					foreach (static::EXTRAS as $name) {
						unset($options['options'][$key][$name]);
					}
				}
			}
		}

		$provider = match ($options['type'] ?? null) {
			'api'   => OptionsApi::factory($options),
			'query' => OptionsQuery::factory($options),
			default => Options::factory($options['options'] ?? [])
		};

		$rendered = (new FieldOptions($provider, false))->render($this->model());

		if ($provider instanceof Options === false) {
			foreach ($provider->items as $value => $data) {
				$extras[$value] = $this->extras($options, $data);
			}
		}

		foreach ($rendered as $index => $option) {
			$rendered[$index] += $extras[$option['value']] ?? [];
		}

		return $rendered;
	}

	protected function font(string|null $font, array $data): string|null
	{
		$font = $this->template($font, $data);

		return match ($font) {
			'monospace', 'mono' => 'var(--font-mono)',
			'sans-serif'        => 'var(--font-sans)',
			default             => $font
		};
	}

	protected function image(string|array|false|null $settings, array $data): array|null
	{
		if ($settings === null || $settings === false) {
			return null;
		}

		$item = $data['item'] ?? null;

		if ($item instanceof ModelWithContent) {
			return $item->panel()->image($settings);
		}

		if (is_string($settings) === true) {
			$settings = ['query' => $settings];
		}

		if (isset($settings['query']) === false) {
			$settings = array_map(
				fn ($value) => is_string($value) === true ? $this->template($value, $data) : $value,
				$settings
			);

			return array_filter($settings, fn ($value) => $value !== null) ?: null;
		}

		$model = $this->model();

		try {
			$result = Str::query($settings['query'], [
				'kirby'             => $model->kirby(),
				'site'              => $model->site(),
				'model'             => $model,
				$model::CLASS_ALIAS => $model,
				...$data
			]);
		} catch (Throwable) {
			return null;
		}

		if ($result instanceof ModelWithContent === false) {
			return null;
		}

		return $result->panel()->image([...$settings, 'query' => null]);
	}

	protected function extras(array $settings, array $data = []): array
	{
		return array_filter([
			'font'  => $this->font($settings['font'] ?? null, $data),
			'image' => $this->image($settings['image'] ?? null, $data),
			'theme' => $this->template($settings['theme'] ?? null, $data)
		]);
	}

	protected function template(string|null $template, array $data): string|null
	{
		if ($template === null) {
			return null;
		}

		return $this->model()->toString($template, $data) ?: null;
	}
}
