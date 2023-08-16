<script setup>
import AuthenticatedLayout from '@/admin/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Container from '@/admin/Components/Container.vue';
import Button from '@/admin/Components/Base/Button.vue';
import Card from '@/admin/Components/Card/Card.vue';
import InputGroup from '@/admin/Components/Form/InputGroup.vue';
import SelectGroup from '@/admin/Components/Form/SelectGroup.vue';


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
    },
    roles: {
        type: Array,
    }
});

const form = useForm({
    name: props.item.name ?? "",
    email: props.item.email ?? "",
    password:  "",
    password_confirmation: "",
    role_id: props.action == 'edit' ? (props.item.roles[0]?.id ?? "") : "",
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
                    <div class="grid grid-cols-2 gap-6">

                        <InputGroup v-model="form.name" id="name" required label="Name" :error-message="form.errors.name" />

                        <InputGroup type="email" v-model="form.email" id="email" required label="Email"
                            :error-message="form.errors.email" />

                        <InputGroup type="password" v-model="form.password" id="password" :required="action == 'create'"
                            label="Password" :error-message="form.errors.password" />

                        <InputGroup type="password" v-model="form.password_confirmation" id="password_confirmation"
                            :required="action == 'create'" label="Confirm Password"
                            :error-message="form.errors.password_confirmation" />

                        <SelectGroup label="Role" v-model="form.role_id" :items="roles" :error-message="form.errors.role_id"
                            required />
                    </div>

                    <Button color="black" type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Saving...' : 'Save' }}
                    </Button>

                </form>
            </Card>

    </AuthenticatedLayout>
</template>
