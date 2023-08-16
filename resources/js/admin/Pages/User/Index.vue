<script setup>
import { Head, } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/admin/Layouts/AuthenticatedLayout.vue';
import Container from '@/admin/Components/Container.vue';
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

</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout :title="title">
        <template #actions>
            <Button v-if="can.create" color="black" :href="route(`admin.${routeResourceName}.create`)">Create</Button>
        </template>
        <Card>
            <BasicFilter v-model="filters" />

            <Table :headers="headers" :items="items" class="mt-6">
                <template v-slot="{ item }">

                    <Td>{{ item.name }}</Td>
                    <Td>{{ item.email }}</Td>
                    <Td>
                        <Button color="blue" class="mx-1" small v-for="role in item.roles" :key="role.id">
                            {{ role.name }}
                        </Button>
                    </Td>
                    <Td>{{ item.created_at }}</Td>
                    <Td>
                        <Actions :edit-link="route(`admin.${routeResourceName}.edit`, item.id)" :show-edit="item.can.update"
                            :show-delete="item.can.delete" @deleteClicked="showDeleteModal(item)" />
                    </Td>
                </template>
            </Table>

            <Modal :show="deleteModal" @close="closeModal" :title="`Delete: (${itemToDelete.name})`">

                <template #description>
                    Once you are delete, you un-able to restore it again.
                </template>

                <template #footer>
                    <Button color="white" @click="closeModal"> Cancel </Button>

                    <Button color="red" class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="handleDeleteItem">
                        Delete
                    </Button>
                </template>
            </Modal>
        </Card>
    </AuthenticatedLayout>
</template>
