<script setup>
import NavLink from '@/admin/Components/Nav/NavLink.vue';

</script>
<template>
    <!-- Navigation Links -->
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <NavLink :href="route('admin.dashboard')" :active="route().current('admin.dashboard')">
            Dashboard
        </NavLink>
        <NavLink :href="route('admin.roles.index')" :active="route().current('admin.roles.*')">
            Role
        </NavLink>
        <NavLink :href="route('admin.permissions.index')" :active="route().current('admin.permissions.*')">
            Permission
        </NavLink>
    </div>
</template>
