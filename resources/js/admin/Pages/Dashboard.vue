<script setup>
import AuthenticatedLayout from '@/admin/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Card from '@/admin/Components/Card/Card.vue';

const title = 'Dashboard';
</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout :title="title">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <Card>
            You're logged in!
        </Card>

    </AuthenticatedLayout>
</template>
