<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/admin/Layouts/AuthenticatedLayout.vue';
import Container from '@/admin/Components/Container.vue';
import Modal from '@/admin/Components/Modal.vue';
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

const confirmingModelDeletion = ref(false);

const itemToDelete = ref({});
const confirmModelDeletion = (item) => {
    confirmingModelDeletion.value = true;
    itemToDelete.value = item;

};

const form = useForm({});

const closeModal = () => {
    confirmingModelDeletion.value = false;
    form.reset();
};

const deleteModel = () => {
    form.delete(route('admin.roles.destroy', itemToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};
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
                            <Actions :edit-link="route('admin.roles.edit', item.id)"
                                @deleteClicked="confirmModelDeletion(item)" />

                            <Modal :show="confirmingModelDeletion" @close="closeModal"
                                :title="`Delete Role: (${itemToDelete.name})`">

                                <template #description>
                                    Once you are delete a role, you un-able to restore it again.
                                </template>


                                <template #footer>
                                    <Button color="secondary" @click="closeModal"> Cancel </Button>

                                    <Button color="danger" class="ml-3" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing" @click="deleteModel">
                                        Delete Role
                                    </Button>
                                </template>
                            </Modal>
                        </Td>
                    </template>
                </Table>
            </Card>
        </Container>
    </AuthenticatedLayout>
</template>
