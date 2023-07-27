<script setup>
import { ref } from 'vue';
import ResponsiveNavLink from '@/admin/Components/Nav/ResponsiveNavLink.vue';

defineProps({
    showNavigation: {
        type: Boolean,
    },
});</script>
<template>
    <!-- Responsive Navigation Menu -->
    <div :class="{ block: showNavigation, hidden: !showNavigation }" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink :href="route('admin.dashboard')" :active="route().current('admin.dashboard')">
                Dashboard
            </ResponsiveNavLink>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800">
                    {{ $page.props.auth.user.name }}
                </div>
                <div class="text-sm font-medium text-gray-500">{{ $page.props.auth.user.email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                    Log Out
                </ResponsiveNavLink>
            </div>
        </div>
    </div>
</template>
