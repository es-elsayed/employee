import { ref } from "vue";
import { useForm } from '@inertiajs/vue3';


export default function (params) {

    const { routeResourceName } = params;

    const deleteModal = ref(false);
    const itemToDelete = ref({});
    const form = useForm({});

    const showDeleteModal = (item) => {
        deleteModal.value = true;
        itemToDelete.value = item;
    };

    const closeModal = () => {
        deleteModal.value = false;
        form.reset();
    };

    const handleDeleteItem = () => {
        form.delete(route(`admin.${routeResourceName}.destroy`, itemToDelete.value.id), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onFinish: () => form.reset(),
        });
    };

    return {
        deleteModal,
        itemToDelete,
        form,
        showDeleteModal,
        closeModal,
        handleDeleteItem,
    }
}
