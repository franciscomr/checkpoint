<script setup lang="ts">
import * as icons from 'lucide-vue-next';
import { computed } from 'vue';

const iconMap: any = icons;

interface Props {
    name?: string;
    size?: 'sm' | 'md' | 'lg';
    ariaLabel?: string;
}

const props = withDefaults(defineProps<Props>(), {
    name: 'Heart',
    size: 'md',
    ariaLabel: 'Icon',
});

const iconComponent = computed(() => iconMap[props.name] || null);
const size = computed(() => props.size ?? 'md');
const ariaLabel = computed(() => props.ariaLabel ?? props.name);
</script>

<template>
    <component :is="iconComponent" v-if="iconComponent" class="icon" :class="[`icon--${size}`]" :aria-label="ariaLabel" role="img" />
    <span v-else class="icon-missing" aria-hidden="true">?</span>
</template>

<style scoped>
.icon--sm {
    width: 16px;
    height: 16px;
}

.icon--md {
    width: 20px;
    height: 20px;
}

.icon--lg {
    width: 24px;
    height: 24px;
}

.icon-missing {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--color-border);
    width: 20px;
    height: 20px;
    font-size: 0.875rem;
}
</style>
