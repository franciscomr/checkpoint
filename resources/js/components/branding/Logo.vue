<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Props {
    src: string;
    label?: string;
    labelPosition?: 'right' | 'bottom';
    size?: 'sm' | 'md' | 'lg' | 'xl';
    href?: string;
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    labelPosition: 'right',
    size: 'md',
});

const sizeClass = computed(() => {
    return `logo--${props.size}`;
});
</script>

<template>
    <component :is="href ? Link : 'div'" :href="href" class="logo" :class="[`logo--label-${labelPosition}`, sizeClass, props.class]">
        <img :src="props.src" alt="Logo" class="logo__img" draggable="false" />

        <span v-if="label" :class="`logo--label-${size}`">{{ label }}</span>
    </component>
</template>

<style scoped>
.logo {
    display: inline-flex;
    align-items: center;
    user-select: none;
    gap: var(--space-2);
    color: var(--color-on-surface);
}

.logo--label-right {
    flex-direction: row;
}

.logo--label-bottom {
    flex-direction: column;
    align-items: center;
    /*  align-items: flex-start;*/
}

.logo--label-sm {
    font-size: 0.75rem;
    font-weight: var(--font-weight-semibold);
}

.logo--label-md {
    font-size: 0.875rem;
    font-weight: var(--font-weight-semibold);
}

.logo--label-lg {
    font-size: 1.125rem;
    font-weight: var(--font-weight-semibold);
}

.logo--label-xl {
    font-size: 1.5rem;
    font-weight: var(--font-weight-semibold);
}

.logo__img {
    object-fit: contain;
}

.logo--sm .logo__img {
    width: auto;
    height: 24px;
}

.logo--md .logo__img {
    width: auto;
    height: 32px;
}

.logo--lg .logo__img {
    width: auto;
    height: 48px;
}

.logo--xl .logo__img {
    width: auto;
    height: 56px;
}

.logo__label {
    font-size: 1rem;
    font-weight: var(--font-weight-semibold);
    color: var(--color-text);
}

@media (max-width: var(--breakpoint-mobile)) {
    .logo__img {
        max-width: 80%;
    }
}
</style>
