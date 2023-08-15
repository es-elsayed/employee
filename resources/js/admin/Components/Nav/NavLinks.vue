<script setup>
import NavLink from './NavLink.vue';

</script>
<template>
    <!-- Navigation Links -->
    <nav class="mt-10">
        <NavLink v-for="menu in $page.props.menus" v-show="menu.isVisible" :href="menu.url" :active="menu.isActive"
            :key="menu.label">
            {{ menu.label }}
        </NavLink>
    </nav>
</template>
