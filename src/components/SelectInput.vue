<template>
	<span
		:class="['k-select-input', $attrs.class]"
		:data-disabled="disabled"
		:data-empty="isEmpty"
		:style="$attrs.style"
	>
		<select
			:id="id"
			ref="input"
			:autofocus="autofocus"
			:aria-label="ariaLabel"
			:disabled="disabled"
			:name="name"
			:required="required"
			:value="value"
			class="k-select-input-native"
			@change="$emit('input', $event.target.value)"
			@click="onClick"
		>
			<button class="k-select-input-button">
				<component is="selectedcontent" class="k-select-input-selected" />
			</button>
			<option
				v-if="hasEmptyOption"
				:disabled="required"
				class="k-select-input-option"
				value=""
			>
				<span class="k-select-input-option-content">
					<k-icon
						v-if="placeholderIcon"
						:type="placeholderIcon"
						class="k-select-input-option-icon"
					/>
					<span class="k-select-input-option-label">
						<span class="k-select-input-option-text">{{ empty }}</span>
					</span>
				</span>
			</option>
			<option
				v-for="option in options"
				:key="option.value"
				:disabled="option.disabled"
				:value="option.value"
				class="k-select-input-option"
			>
				<span
					:style="{ fontFamily: option.font }"
					class="k-select-input-option-content"
				>
					<k-image-frame
						v-if="option.image?.src"
						v-bind="option.image"
						class="k-select-input-option-image"
					/>
					<k-icon-frame
						v-else-if="option.image"
						v-bind="option.image"
						class="k-select-input-option-image"
					/>
					<k-icon
						v-else-if="option.icon"
						:data-theme="option.theme"
						:type="option.icon"
						class="k-select-input-option-icon"
					/>
					<span class="k-select-input-option-label">
						<span class="k-select-input-option-text">{{ option.text }}</span>
						<template v-if="option.info">
							<span class="sr-only">, </span>
							<span class="k-select-input-option-info">{{ option.info }}</span>
						</template>
					</span>
				</span>
			</option>
		</select>
		<span class="k-select-input-label">{{ label }}</span>
	</span>
</template>

<script>
export default {
	extends: "k-select-input",
	props: {
		placeholderIcon: String
	}
};
</script>

<style>
:root {
	--select-option-color-back: transparent;
	--select-option-color-text: var(--dropdown-color-text);
	--select-option-image-size: 1rem;
}

@supports (appearance: base-select) {
	@media (hover: hover) and (pointer: fine) {
		/* Field context */
		.k-select-field .k-input-element {
			align-self: stretch;
		}
		.k-select-field .k-select-input {
			display: flex;
			align-items: center;
			height: 100%;
		}
		.k-select-field .k-select-input:has(.k-select-input-option:checked) .k-select-input-label {
			visibility: hidden;
		}

		/* Native select */
		.k-select-field .k-select-input-native,
		.k-select-field .k-select-input-native::picker(select) {
			appearance: base-select;
		}
		.k-select-field .k-select-input-native {
			display: flex;
			align-items: center;
			padding: var(--input-padding);
			padding-inline-end: var(--input-height);
			border-radius: var(--input-rounded);
			background: none;
			color: inherit;
			opacity: 1;
			outline: 0;
		}
		.k-select-field .k-select-input-native::picker-icon {
			display: none;
		}
		.k-select-field .k-select-input-native::picker(select) {
			--color-text-dimmed: var(--color-gray-400);

			width: max-content;
			max-width: max(anchor-size(width), min(30rem, 100% - 10px));
			max-height: calc(var(--height-sm) * 9.5 + var(--dropdown-padding) * 2);
			position-try-order: normal;
			padding: var(--dropdown-padding);
			border: 0;
			border-radius: var(--dropdown-rounded);
			background: var(--dropdown-color-bg);
			box-shadow: var(--dropdown-shadow);
			color-scheme: dark;
			color: var(--dropdown-color-text);
			font-size: var(--text-sm);
			overscroll-behavior: contain;
			scroll-padding-block: var(--dropdown-padding);
		}

		/* Selected option */
		.k-select-field .k-select-input-button {
			display: flex;
			flex-grow: 1;
			min-width: 0;
		}
		.k-select-field .k-select-input-selected {
			--select-option-image-size: calc(var(--input-height) - var(--input-padding) * 2);

			min-width: 0;
			line-height: var(--leading-tight);
			white-space: nowrap;
		}
		.k-select-field .k-select-input-selected .k-select-input-option-label {
			display: flex;
			gap: var(--spacing-2);
			min-width: 0;
		}
		.k-select-field .k-select-input-selected .k-select-input-option-text,
		.k-select-field .k-select-input-selected .k-select-input-option-info {
			overflow: hidden;
			text-overflow: ellipsis;
		}
		.k-select-field .k-select-input-selected .k-select-input-option-text {
			flex-shrink: 0;
			max-width: 100%;
		}

		/* Options */
		.k-select-field .k-select-input-option {
			--icon-size: 1rem;

			display: flex;
			align-items: center;
			gap: var(--spacing-2);
			padding: 0.375rem var(--spacing-2);
			border-radius: var(--rounded-sm);
			background: var(--select-option-color-back);
			color: var(--select-option-color-text);
			line-height: 1rem;
		}
		.k-select-field .k-select-input-option:not(:disabled):hover {
			--select-option-color-back: var(--dropdown-color-hr);
		}
		.k-select-field .k-select-input-option:checked {
			--select-option-color-text: var(--dropdown-color-current);
		}
		.k-select-field .k-select-input-option:disabled {
			opacity: var(--opacity-disabled);
		}
		.k-select-field .k-select-input-option:has(.k-select-input-option-info) {
			--select-option-image-size: calc(2rem + var(--spacing-1));
		}
		.k-select-field .k-select-input-option::checkmark {
			order: 1;
			margin-inline-start: auto;
			padding-inline-start: var(--spacing-1);
		}
		.k-select-field .k-select-input-option .k-select-input-option-label {
			display: grid;
			gap: var(--spacing-1);
			min-width: 0;
			overflow-wrap: anywhere;
			white-space: normal;
		}

		/* Option content */
		.k-select-field .k-select-input-option-content {
			display: flex;
			flex-grow: 1;
			align-items: center;
			gap: var(--spacing-2);
			min-width: 0;
		}
		.k-select-field .k-select-input-option-image {
			flex-shrink: 0;
			width: var(--select-option-image-size);
			height: var(--select-option-image-size);
			border-radius: var(--rounded-sm);
		}
		.k-select-field .k-select-input-option-icon[data-theme] {
			--icon-color: var(--theme-color-icon);
		}
		.k-select-field .k-select-input-option-info {
			color: var(--color-text-dimmed);
		}
	}
}
</style>
