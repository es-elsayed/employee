<script setup>
import Button from '@/admin/Components/Base/Button.vue';
import Error from '@/admin/Components/Form/Error.vue';
import Label from '@/admin/Components/Form/Label.vue';
import Modal from '@/admin/Components/Modal.vue';
import Input from '@/admin/Components/Form/Input.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Delete Account</h2>

            <p class="mt-1 text-sm text-gray-600">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
                your account, please download any data or information that you wish to retain.
            </p>
        </header>

        <Button @click="confirmUserDeletion" color="red">Delete Account</Button>

        <Modal :show="confirmingUserDeletion" @close="closeModal" title="Are you sure you want to delete your account?">

            <template #description>
                Once your account is deleted, all of its resources and data will be permanently deleted. Please
                enter your password to confirm you would like to permanently delete your account.
            </template>

            <div class="mt-6">
                <Label for="password" value="Password" class="sr-only" />

                <Input id="password" ref="passwordInput" v-model="form.password" type="password"
                    class="block w-3/4 mt-1" placeholder="Password" @keyup.enter="deleteUser" />

                <Error :message="form.errors.password" class="mt-2" />
            </div>

            <template #footer>
                <Button color="white" @click="closeModal"> Cancel </Button>

                <Button color="red" class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteUser">
                    Delete Account
                </Button>
            </template>
        </Modal>
    </section>
</template>
