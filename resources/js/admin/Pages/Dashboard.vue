<script setup>
import AuthenticatedLayout from '@/admin/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Container from '@/admin/Components/Container.vue';
import Card from '@/admin/Components/Card/Card.vue';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <Container>
            <Card>
                    You're logged in!
            </Card>
        </Container>
    </AuthenticatedLayout>
</template>
