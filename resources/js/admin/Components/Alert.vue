<script setup>
import { onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";

const flash = usePage().props.flash;

let classes = 'fixed top-0 right-0 z-10 px-4 py-2 mr-4 mt-4 text-white rounded-xl ';

onMounted(() => {
    setTimeout(() => { flash.success = flash.error = null }, 5000);
})

</script>
<template>
    <div v-if="flash.success" :class="classes + ' bg-green-600'">{{ flash.success }}
    </div>
    <div v-else-if="flash.error" :class="classes + ' bg-red-600'">{{ flash.error }}
    </div>
</template>
