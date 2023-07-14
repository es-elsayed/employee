<script setup>
import AuthenticatedLayout from '@/admin/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Container from '@/admin/Components/Container.vue';
import Button from '@/admin/Components/Buttons/Button.vue';
import Card from '@/admin/Components/Card/Card.vue';
import FormInput from '@/admin/Components/Form/FormInput.vue';


defineProps({})
const form = useForm({
    name: '',
    guard_name: '',
});

const submit = () => {
    form.post(route('admin.roles.store'));
};
</script>

<template>
    <Head title="Create Role" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create Role
            </h2>
        </template>

        <Container>
            <Card>
                <form @submit.prevent="submit" class="mt-6 space-y-6">

                    <FormInput v-model="form.name" id="name" required label="Name"
                        :error-message="form.errors.name" />

                    <FormInput v-model="form.guard_name" id="guard_name" label="Guard Name"
                        :error-message="form.errors.guard_name" />


                    <Button color="primary" type="submit" :disabled="form.processing">Save</Button>
                </form>
            </Card>
        </Container>
    </AuthenticatedLayout>
</template>
