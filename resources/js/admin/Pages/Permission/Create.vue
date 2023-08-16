<script setup>
import AuthenticatedLayout from '@/admin/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Container from '@/admin/Components/Container.vue';
import Button from '@/admin/Components/Base/Button.vue';
import Card from '@/admin/Components/Card/Card.vue';
import InputGroup from '@/admin/Components/Form/InputGroup.vue';


const props = defineProps({
    title: {
        type: String,
    },
    action: {
        type: String,
        default: '',
        validator: (value) => {
            return ['create', 'edit'].includes(value);
        },
    },
    item: {
        type: Object,
        default: ({})
    },
    routeResourceName: {
        type: String,
        required: true,
    }
});

const form = useForm({
    name: props.item.name ?? "",
});


const submit = () => {
    props.action === 'create' ?
        form.post(route(`admin.${props.routeResourceName}.store`)) :
        form.put(route(`admin.${props.routeResourceName}.update`, props.item.id));

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

        <Card>
            <form @submit.prevent="submit" class="mt-6 space-y-6">

                <InputGroup v-model="form.name" id="name" required label="Name" :error-message="form.errors.name" />

                <Button color="black" type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Saving...' : 'Save' }}
                </Button>

            </form>
        </Card>
    </AuthenticatedLayout>
</template>
