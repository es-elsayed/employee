<script setup>
import { ref } from 'vue';
import SidebarEmployee from './SidebarEmployee.vue'
import HeaderEmployee from './HeaderEmployee.vue'
import Alert from '@/admin/Components/Alert.vue';

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
        <!-- <SidebarEmployee /> -->
        <Alert />

        <div class="flex flex-col flex-1 overflow-hidden">
            <HeaderEmployee />

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
