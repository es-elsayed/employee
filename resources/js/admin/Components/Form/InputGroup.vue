<script setup>
import Input from "./Input.vue";
import Label from "./Label.vue";
import Error from "./Error.vue";

defineProps({
    modelValue: {},
    type: {
        type: String,
        default: "text",
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
        <Input :type="type" class="block w-full mt-1" :model-value="modelValue"
            @update:model-value="$emit('update:modelValue', $event)" v-bind="$attrs" />
        <Error v-if="errorMessage" class="mt-1" :message="errorMessage" />
    </div>
</template>
<!--
    // if you want to use every component dividual you can use the next code

    <div>
        <Label for="sample" value="Sample Text" />
        <Input
            id="sample"
            v-model="form.sample"
            type="text"
            class="block w-full mt-1"
            autocomplete="sample"
        />
        <Error :message="form.errors.sample" class="mt-2" />
    </div>
-->
