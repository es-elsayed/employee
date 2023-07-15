<script setup>
import AuthenticatedLayout from '@/admin/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Container from '@/admin/Components/Container.vue';
import Button from '@/admin/Components/Buttons/Button.vue';
import Card from '@/admin/Components/Card/Card.vue';
import FormInput from '@/admin/Components/Form/FormInput.vue';


const props = defineProps({
    role: {
        type: Object,
        default: ({})
    },
})
const form = useForm({
    name: '',
    guard_name: '',
});
let title = "";

if (Object.keys(props.role).length === 0) {
    title = "Add Role";
} else {
    title = "Edit Role"
    form.name = props.role.name
    form.guard_name = props.role.guard_name
}

const submit = () => {
    Object.keys(props.role).length === 0 ?
        form.post(route('admin.roles.store')) :
        form.put(route('admin.roles.update', props.role.id));

};
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
            <Card>
                <form @submit.prevent="submit" class="mt-6 space-y-6">

                    <FormInput v-model="form.name" id="name" required label="Name" :error-message="form.errors.name" />

                    <FormInput v-model="form.guard_name" id="guard_name" label="Guard Name"
                        :error-message="form.errors.guard_name" />

                    <Button color="primary" type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Saving...' : 'Save' }}
                    </Button>

                </form>
            </Card>
        </Container>
    </AuthenticatedLayout>
</template>
