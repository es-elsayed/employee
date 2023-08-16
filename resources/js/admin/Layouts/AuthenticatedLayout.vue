<script setup>
import { ref } from 'vue';
import Sidebar from './Sidebar.vue'
import Header from './Header.vue'

const showingNavigationDropdown = ref(false);
defineProps({
    title: {
        type: String,
        default: "",
        required: false
    }
})
</script>

<template>
    <div class="flex h-screen bg-gray-200 font-roboto">
        <Sidebar />

        <div class="flex flex-col flex-1 overflow-hidden">
            <Header />

            <section class="bg-gray-200">
                <div class="container flex justify-between px-6 py-4 mx-auto sm:px-6 lg:px-8">
                    <h3 v-if="title" class="text-3xl font-medium text-gray-700">
                        {{ title }}
                    </h3>
                    <div class="flex justify-between" v-if="$slots.actions">
                        <slot name="actions" />
                    </div>
                </div>
            </section>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container px-6 py-4 mx-auto">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
