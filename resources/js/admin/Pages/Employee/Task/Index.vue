<script setup>
import AuthenticatedLayoutEmployee from '@/admin/Layouts/AuthenticatedLayoutEmployee.vue';

import { Head, useForm } from '@inertiajs/vue3';
import Modal from '@/admin/Components/Modal.vue';
import Card from '@/admin/Components/Card/Card.vue';
import Table from '@/admin/Components/Table/Table.vue';
import Actions from '@/admin/Components/Table/Actions.vue';
import Button from '@/admin/Components/Base/Button.vue';
import Td from '@/admin/Components/Table/Td.vue';
import BasicFilter from '@/admin/Components/BasicFilter.vue';
import useDeleteItem from '@/admin/Composable/useDeleteItem.js';
import useFilter from '@/admin/Composable/useFilter.js';


const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    items: {
        type: Object,
        default: () => ({}),
    },
    headers: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    routeResourceName: {
        type: String,
        required: true,
    },
    can: Object

})

const {
    deleteModal,
    itemToDelete,
    form,
    showDeleteModal,
    closeModal,
    handleDeleteItem,
} = useDeleteItem({ routeResourceName: props.routeResourceName, });

const { filters } = useFilter({
    filters: props.filters,
    routeResourceName: props.routeResourceName,
});

const completeForm = useForm({});

const complete = (item) => {
    console.log(item, item.id);
    completeForm.put(route(`employee.${props.routeResourceName}.complete`, item.id));
};

console.log('hererere');
</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayoutEmployee :title="title">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>


        <Card class="mt-4">
            <BasicFilter v-model="filters" />

            <Table :headers="headers" :items="items" class="mt-6">
                <template v-slot="{ item }">
                    <Td>
                        <input type="checkbox" name="completed_at" :checked="item.completed_at" @click="complete(item)">
                    </Td>
                    <Td>{{ item.name }}</Td>
                    <Td>{{ item.employee.full_name }}</Td>
                    <Td>
                        <Button color="blue" class="mx-1" small>
                            {{ item.completed_at ? 'completed' : 'opened' }}
                        </Button>
                    </Td>
                    <Td>{{ item.created_at }}</Td>
                    <Td>
                        <Actions :edit-link="route(`employee.${routeResourceName}.edit`, item.id)" :show-edit="item.can.update" :show-delete="item.can.delete"
                            />
                    </Td>
                </template>
            </Table>

        </Card>

    </AuthenticatedLayoutEmployee>
</template>
