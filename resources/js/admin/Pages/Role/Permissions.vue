<script setup>
import { computed, ref } from "vue";
import Container from '@/admin/Components/Container.vue';
import Card from '@/admin/Components/Card/Card.vue';
import Button from '@/admin/Components/Base/Button.vue';
import Input from '@/admin/Components/Form/Input.vue';
import { useForm } from '@inertiajs/vue3';


const props = defineProps({
    role: {
        type: Object,
        default: () => {
            permissions: [];
        },
    },
    permissions: {
        type: Array,
    },
});
const search = ref("");
const permission = ref({});

const form = useForm({
    roleId: props.role.id,
    action: "detach",
});


const filteredPermissions = computed(() => {
    return props.permissions.filter((p) =>
        p.name.toLowerCase().includes(search.value.toLowerCase())
    );
});

const roleHasPermission = (permission) => {
    return props.role.permissions.some((p) => p.id == permission.id);
};

const changePermission = (permission, $action) => {
    form.action = $action;
    form.post(
        route("admin.roles.permission", permission.id),
        {
            preserveScroll: true,
            preserveState: true,
        }
    );
};

const transformText = (text) => {
    return text.split("-").map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(" ")
}

</script>

<template>

        <Card>
            <template #header>
                Permissions
            </template>

            <div class="w-1/4">
                <Input type="text" class="block w-full mt-1" v-model="search" placeholder="Search" />
            </div>

            <ul class="mt-4">
                <li v-for="(permission, index) in filteredPermissions" :key="permission.id"
                    class="flex items-center justify-between px-2 py-2 hover:bg-gray-100" :class="{
                        'border-b': index < (permissions.length - 1),
                    }">
                    <div :class="{ 'text-green-700 font-bold': roleHasPermission(permission) }">
                        {{ transformText(permission.name) }}
                    </div>
                    <Button v-if="roleHasPermission(permission)" @click="changePermission(permission, 'detach')"
                        color="red">Detach</Button>
                    <Button v-else color="green" @click="changePermission(permission, 'attach')">Attach</Button>
                </li>
            </ul>
        </Card>

</template>
