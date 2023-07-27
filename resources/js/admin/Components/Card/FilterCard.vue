
<template>
    <div class="overflow-hidden text-gray-900 bg-white shadow sm:rounded-lg">
        <div v-if="$slots.header" class="px-6 py-2 font-bold border-b bg-gray-50">
            <slot name="header"></slot>
        </div>
        <div class="p-6">

            <slot />

        </div>
    </div>
</template>
