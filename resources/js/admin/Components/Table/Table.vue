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
    <!-- <div class="overflow-x-auto "> -->
    <div class="sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm font-light text-left">
                    <thead class="font-medium border-b dark:border-neutral-500">
                        <Th v-for="header in headers" :key="header.lable">{{ header.label }}</Th>
                    </thead>
                    <tbody>
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
            </div>
        </div>
        <!-- </div> -->
    </div>
</template>
