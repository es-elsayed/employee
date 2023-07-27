<script setup>
import FilterCard from '@/admin/Components/Card/FilterCard.vue';
import FormInput from '@/admin/Components/Form/FormInput.vue';
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
        <form class="grid grid-cols-4 gap-8">
            <div>
                <FormInput lClass="font-semibold" v-model="filters.search" id="search" label="Search:" />
            </div>
        </form>
</template>
