<script setup>
import { ref, watch, onMounted } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
// import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from '@/admin/Layouts/AuthenticatedLayout.vue';
import Container from '@/admin/Components/Container.vue';
import Modal from '@/admin/Components/Modal.vue';
import Card from '@/admin/Components/Card/Card.vue';
import Table from '@/admin/Components/Table/Table.vue';
import Actions from '@/admin/Components/Table/Actions.vue';
import Button from '@/admin/Components/Buttons/Button.vue';
import Td from '@/admin/Components/Table/Td.vue';
import FormInput from '@/admin/Components/Form/FormInput.vue';
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

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ title }}
            </h2>
        </template>

        <Container>
            <Card class="mb-4">
                <template #header>
                    Filter
                </template>
                <form class="grid grid-cols-4 gap-8">
                    <div>

                        <FormInput v-model="filters.name" id="name" label="Name" />
                    </div>
                </form>
            </Card>

            <Button color="primary" :href="route(`admin.${routeResourceName}.create`)">Create</Button>

            <Card class="mt-4">
                <Table :headers="headers" :items="items">
                    <template v-slot="{ item }">
                        <Td>{{ item.name }}</Td>
                        <Td>{{ item.created_at }}</Td>
                        <Td>
                            <Actions :edit-link="route(`admin.${routeResourceName}.edit`, item.id)"
                                @deleteClicked="showDeleteModal(item)" />
                        </Td>
                    </template>
                </Table>

                <Modal :show="deleteModal" @close="closeModal" :title="`Delete Role: (${itemToDelete.name})`">

                    <template #description>
                        Once you are delete a role, you un-able to restore it again.
                    </template>

                    <template #footer>
                        <Button color="secondary" @click="closeModal"> Cancel </Button>

                        <Button color="danger" class="ml-3" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing" @click="handleDeleteItem">
                            Delete Role
                        </Button>
                    </template>
                </Modal>
            </Card>
        </Container>
    </AuthenticatedLayout>
</template>
