<script setup>
import Label from "./Label.vue";
import Error from "./Error.vue";
import Select from "./Select.vue";

defineProps({
    modelValue: {},
    items: Array,
    itemText: {
        type: String,
        default: "name",
    },
    itemValue: {
        type: String,
        default: "id",
    },
    withoutSelect: {
        type: Boolean,
        default: false,
    },
    label: {
        type: String,
        default: "",
    },
    errorMessage: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <div>
        <Label v-if="label" :value="label" />

        <Select class="mt-1" :model-value="modelValue" @update:model-value="$emit('update:modelValue', $event)"
            :items="items" :item-text="itemText" :item-value="itemValue" :without-select="withoutSelect" v-bind="$attrs" />

        <Error v-if="errorMessage" class="mt-1" :message="errorMessage" />
    </div>
</template>
