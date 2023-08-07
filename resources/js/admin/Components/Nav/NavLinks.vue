<script setup>
import NavLink from '@/admin/Components/Nav/NavLink.vue';

</script>
<template>
    <!-- Navigation Links -->
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <NavLink v-for="menu in $page.props.menus" v-show="menu.isVisible" :href="menu.url" :active="menu.isActive">
            {{ menu.label }}
        </NavLink>
    </div>
</template>
