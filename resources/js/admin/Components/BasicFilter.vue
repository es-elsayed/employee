<script setup>
import SearchIcon from '@/admin/Components/Icons/Search.vue';
import { ref, watch } from "vue";


const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({}),
    },
});

const emits = defineEmits(["update:modelValue"]);

const filters = ref({ ...props.modelValue });

watch(
    filters,
    () => {
        emits("update:modelValue", filters.value);
    },
    {
        deep: true,
    }
);

</script>
<template>
    <form class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <SearchIcon/>
        </span>

        <input v-model="filters.search" id="search"
            class="w-32 pl-10 pr-4 text-indigo-600 border-gray-200 rounded-md sm:w-64 focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
            type="text" placeholder="Search">
    </form>
</template>
