<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";


const message = ref("");
const color = ref("");
const timeoutHandler = ref(null);


const handleFlashMessage = (messageText, messageType) => {
    message.value = messageText;
    color.value = `bg-${messageType == "success" ? 'green' : 'red'}-600`;

    if (messageText) {
        clearTimeout(timeoutHandler.value);

        timeoutHandler.value = setTimeout(() => {
            clearMessage(messageType);
        }, 5000);
    }
};

watch(
    () => [usePage().props.flash?.success, usePage().props.flash?.error],
    ([successMessage, errorMessage]) => {
        if (successMessage) {
            handleFlashMessage(successMessage, "success");
        } else if (errorMessage) {
            handleFlashMessage(errorMessage, "error");
        }
    },
    {
        immediate: true,
    }
);

const clearMessage = (messageType) => {
    message.value = "";
    usePage().props.flash[messageType] = ""; // Clear the message
};
</script>

<template>
    <div v-if="message" :class="`fixed bottom-10 right-5 z-10 px-4 py-2 mt-4 mr-4 text-white rounded  ${color}`"
        @click="clearMessage">{{ message }}</div>
</template>
