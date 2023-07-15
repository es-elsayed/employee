<script setup>
import {Link} from "@inertiajs/vue3";
const props = defineProps({
    color: {
        type: String,
        default: '',
        validator: (value) => {
            return ['danger', 'primary', 'secondary'].includes(value);
        },
    },
    type: {
        type: String,
        default: 'button',
    },
    href: {
        type: String,
        default: '',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
let classes = 'inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest uppercase transition duration-150 ease-in-out border rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2'
if (props.color === 'danger') {
    classes += ' text-white bg-red-600 border-transparent hover:bg-red-500 active:bg-red-700 focus:ring-red-500 ';
} else if (props.color === 'primary') {
    classes += ' text-white bg-gray-800 border-transparent hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:ring-indigo-500 ';
} else if (props.color === 'secondary') {
    classes += ' text-gray-700 bg-white border-gray-300 shadow-sm hover:bg-gray-50 focus:ring-indigo-500  disabled:opacity-25';
}
</script>
<template>
    <Link v-if="href" :href="href" :class="classes">
    <slot />
    </Link>
    <button v-else :class="classes" :type="type" :disabled="disabled">
        <slot />
    </button>
</template>

