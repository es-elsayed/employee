<script setup>
import FilterCard from '@/admin/Components/Card/FilterCard.vue';
import InputGroup from '@/admin/Components/Form/InputGroup.vue';
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
    <FilterCard class="mb-4">
        <template #header>
            Filter
        </template>
        <form class="grid grid-cols-4 gap-8">
            <div>
                <InputGroup v-model="filters.name" id="name" label="Name" />
            </div>
        </form>
    </FilterCard>
</template>
