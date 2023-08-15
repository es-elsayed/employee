<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    align: {
        type: String,
        default: 'right',
    },
    width: {
        type: String,
        default: '48',
    },
    contentClasses: {
        type: String,
        default: 'py-1 bg-white',
    },
});

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

// const widthClass = computed(() => {
//     return {
//         48: 'w-48',
//     }[props.width.toString()];
// });

// const alignmentClasses = computed(() => {
//     if (props.align === 'left') {
//         return 'origin-top-left left-0';
//     } else if (props.align === 'right') {
//         return 'origin-top-right right-0';
//     } else {
//         return 'origin-top';
//     }
// });

const dropdownOpen = ref(false);

</script>

<template>
    <div class="relative">
        <button class="relative z-10 block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none"
            @click="dropdownOpen = !dropdownOpen">
            <slot name="trigger" />
        </button>

        <div v-show="dropdownOpen" class="fixed inset-0 z-10 w-full h-full" @click="dropdownOpen = false" />

        <transition enter-active-class="transition duration-150 ease-out transform" enter-from-class="scale-95 opacity-0"
            enter-to-class="scale-100 opacity-100" leave-active-class="transition duration-150 ease-in transform"
            leave-from-class="scale-100 opacity-100" leave-to-class="scale-95 opacity-0">
            <div v-show="dropdownOpen" class="absolute right-0 z-20 w-48 py-2 mt-2 bg-white rounded-md shadow-xl">
                <slot name="content" />
            </div>
        </transition>
    </div>
</template>
