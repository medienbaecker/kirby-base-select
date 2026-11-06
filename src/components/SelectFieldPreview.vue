<template>
	<ul
		:class="[
			'k-select-field-preview',
			'k-tags-field-preview',
			'k-tags',
			$attrs.class
		]"
		:style="$attrs.style"
	>
		<li v-for="tag in tags" :key="tag.value">
			<k-tag
				:icon="tag.icon"
				:image="tag.image"
				:style="{ fontFamily: tag.font }"
				:theme="tag.theme ?? 'light'"
				element="div"
			>
				{{ tag.text }}
				<span v-if="tag.info" class="k-select-field-preview-info">
					{{ tag.info }}
				</span>
			</k-tag>
		</li>
	</ul>
</template>

<script>
export default {
	extends: "k-select-field-preview",
	computed: {
		tags() {
			if (!this.value) {
				return [];
			}

			const options = this.column.options ?? this.field.options ?? [];
			const option = options.find((option) => option.value === this.value);

			return [option ?? { value: this.value, text: this.value }];
		}
	}
};
</script>

<style>
.k-select-field-preview-info {
	color: var(--color-text-dimmed);
}
</style>
