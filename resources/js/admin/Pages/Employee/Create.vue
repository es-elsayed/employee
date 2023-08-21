<script setup>
import AuthenticatedLayout from '@/admin/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import SelectGroup from '@/admin/Components/Form/SelectGroup.vue';
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
    managers: {
        type: Array,
    },
    departments: {
        type: Array,
    },
    routeResourceName: {
        type: String,
        required: true,
    }
});

const form = useForm({
    first_name: props.item.first_name ?? "",
    last_name: props.item.last_name ?? "",
    email: props.item.email ?? "",
    password: "",
    password_confirmation: "",
    salary: props.item.salary ?? "",
    department_id: props.action == 'edit' ? (props.item.department_id ?? "") : "",
    manager_id: props.action == 'edit' ? (props.item.manager_id ?? "") : "",
    image: "",

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

                <InputGroup v-model="form.first_name" id="first_name" required label="First Name"
                    :error-message="form.errors.first_name" />
                <InputGroup v-model="form.last_name" id="last_name" required label="Last Name"
                    :error-message="form.errors.last_name" />

                <InputGroup v-model="form.email" id="email" type="email" required label="Email"
                    :error-message="form.errors.email" />

                <InputGroup v-model="form.password" id="password" type="password" :required="action == 'create'"
                    label="Password" :error-message="form.errors.password" />

                <InputGroup v-model="form.password_confirmation" id="password_confirmation" type="password"
                    :required="action == 'create'" label="Confirm Password"
                    :error-message="form.errors.password_confirmation" />

                <InputGroup v-model="form.salary" id="salary" type="number" required label="Salary"
                    :error-message="form.errors.salary" />

                <div v-if="action == 'create'">
                    <Label value="Image" />
                    <input type="file" @input="form.image = $event.target.files[0]" />
                    <Error v-if="form.errors.image" class="mt-1" :message="form.errors.image" />
                </div>

                <SelectGroup label="Department" v-model="form.department_id" item-text="name" :items="departments"
                    :error-message="form.errors.department_id" required />

                <SelectGroup label="Manager" v-model="form.manager_id" :items="managers"
                    :error-message="form.errors.manager_id" required />

                <Button color="black" type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Saving...' : 'Save' }}
                </Button>

            </form>
        </Card>
    </AuthenticatedLayout>
</template>
