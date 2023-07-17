<script setup>
import { Link } from "@inertiajs/vue3";
import EditIcon from "@/admin/Components/Icons/Edit.vue";
import DeleteIcon from "@/admin/Components/Icons/Delete.vue";
defineProps({
    editLink: {
        type: String,
        default: () => ""
    },
    showEdit: {
        type: Boolean,
        default: () => true
    },
    showDelete: {
        type: Boolean,
        default: () => true
    },
})
</script>
<template>
    <div class="flex items-center space-x-2">
        <button v-if="showEdit">
            <Link :href="editLink">
            <EditIcon class="w-4 h-4" />
            </Link>
        </button>
        <button v-if="showDelete" @click="$emit('deleteClicked', $event)">
            <DeleteIcon class="w-4 h-4" />
        </button>
    </div>
</template>
