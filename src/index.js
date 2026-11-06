import SelectField from "./components/SelectField.vue";
import SelectFieldPreview from "./components/SelectFieldPreview.vue";
import SelectInput from "./components/SelectInput.vue";

panel.plugin("medienbaecker/select", {
	components: {
		"k-select-field": SelectField,
		"k-select-field-preview": SelectFieldPreview,
		"k-select-input": SelectInput
	}
});
