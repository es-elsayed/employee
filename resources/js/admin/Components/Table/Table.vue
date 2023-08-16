<script setup>
import Th from "./Th.vue";
import Tr from "./Tr.vue";
import Td from "./Td.vue";
defineProps({
    headers: {
        type: Array,
        default: () => []
    },
    items: {
        type: Object,
        default: () => ({})
    },
})
</script>
<template>
    <table class="min-w-full">

        <thead>
            <Th v-for="header in headers" :key="header.lable">{{ header.label }}</Th>
        </thead>

        <tbody class="bg-white">
            <Tr v-if="items.data.length === 0">
                <Td :colspan="headers.length">
                    No Data Available
                </Td>
            </Tr>
            <Tr v-else v-for="item in items.data" :key="item.id">
                <slot :item="item" />
            </Tr>
        </tbody>

    </table>
</template>
