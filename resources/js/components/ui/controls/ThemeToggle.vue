<script setup lang="ts">
import Icon from '@/components/ui/icons/Icon.vue';
import { useTheme } from '@/composables/useTheme';
const { theme, toggleTheme } = useTheme();
</script>

<template>
    <button class="theme-toggle" @click="toggleTheme" :aria-label="`Activate ${theme === 'dark' ? 'light' : 'dark'} mode`">
        <Icon :name="theme === 'dark' ? 'Sun' : 'Moon'" size="md" />
    </button>
</template>
