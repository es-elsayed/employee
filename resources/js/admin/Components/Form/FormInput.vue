<script setup>

import InputError from '@/admin/Components/InputError.vue';
import InputLabel from '@/admin/Components/InputLabel.vue';
import TextInput from '@/admin/Components/TextInput.vue';
import { computed } from 'vue'

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    // group Class
    gClass: {
        type: String,
        default: '',
    },
    label: {
        type: String,
        default: '',
    },
    // lable Class
    lClass: {
        type: String,
        default: '',
    },
    // input Class
    iClass: {
        type: String,
        default: '',
    },
    modelValue: {
        type: String,
        default: "",
        required: true,
    },
    id: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: 'text',
    },
    required: {
        type: Boolean,
        default: false,
    },
    autofocus: {
        type: Boolean,
        default: false,
    },
    autocomplete: {
        type: String,
        default: 'off',
    },
    errorMessage: {
        type: String,
        default: '',
    },
});

const value = computed({
    get() {
        return props.modelValue
    },
    set(value) {
        emit('update:modelValue', value)
    }
})
</script>

<template>
    <div :class="gClass">
        <InputLabel v-if="label" :for="id" :value="label" :class="lClass" />

        <TextInput :id="id" v-model="value" :type="type" :class="'block w-full mt-1 ' + iClass" :required="required"
            :autofocus="autofocus" :autocomplete="autocomplete" />

        <InputError v-if="errorMessage" class="mt-2" :message="errorMessage" />
    </div>
</template>


<!--
    // if you want to use every component dividual you can use the next code

    <div>
        <InputLabel for="sample" value="Sample Text" />
        <TextInput
            id="sample"
            v-model="form.sample"
            type="text"
            class="block w-full mt-1"
            autocomplete="sample"
        />
        <InputError :message="form.errors.sample" class="mt-2" />
    </div>
-->
