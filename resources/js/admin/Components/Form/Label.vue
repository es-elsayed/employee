<script setup>
defineProps({
    value: {
        type: String,
    },
    required: Boolean
});
</script>

<template>
    <label class="block text-sm font-medium text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-if="required" class="text-red-600">&#160;*</span>
        <span v-else><slot /></span>
    </label>
</template>
