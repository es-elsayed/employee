
<template>
    <div class="p-4 overflow-hidden text-gray-900 bg-white shadow-sm sm:p-6 sm:rounded-lg">
        <div v-if="$slots.header" class="px-4 py-2 font-bold border-b sm:px-6 bg-gray-50">
            <slot name="header"></slot>
        </div>
        <slot />
    </div>
</template>
