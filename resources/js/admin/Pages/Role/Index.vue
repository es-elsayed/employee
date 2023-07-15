<script setup>
import AuthenticatedLayout from '@/admin/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Container from '@/admin/Components/Container.vue';
import Card from '@/admin/Components/Card/Card.vue';
import Table from '@/admin/Components/Table/Table.vue';
import Actions from '@/admin/Components/Table/Actions.vue';
import Button from '@/admin/Components/Buttons/Button.vue';
import Td from '@/admin/Components/Table/Td.vue';

defineProps({
    roles: {
        type: Object,
        default: () => ({})
    },
    headers: {
        type: Object,
        default: () => ({})
    },

})

</script>

<template>
    <Head title="Role" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Roles</h2>
        </template>

        <Container>
            <Button color="primary" :href="route('admin.roles.create')">Create</Button>

            <Card class="mt-4">
                <Table :headers="headers" :items="roles">
                    <template v-slot="{ item }">
                        <Td>{{ item.name }}</Td>
                        <Td>{{ item.created_at }}</Td>
                        <Td>
                            <Actions :edit-link="route('admin.roles.edit',  item.id )" />
                        </Td>
                    </template>
                </Table>
            </Card>
        </Container>
    </AuthenticatedLayout>
</template>
