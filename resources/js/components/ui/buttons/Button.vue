<script setup lang="ts">
import { computed, useSlots } from "vue";

// --------------------------------------------------
// Props definition
// --------------------------------------------------
interface ButtonProps {
  label?: string;
  variant?: "primary" | "secondary" | "outline";
  size?: "sm" | "md" | "lg";
  icon?: boolean;
  iconPosition?: "left" | "right";
  disabled?: boolean;
  loading?: boolean;
  ariaLabel?: string; // extra opcional para accesibilidad
}

const props = withDefaults(defineProps<ButtonProps>(), {
  variant: "primary",
  size: "md",
  icon: false,
  iconPosition: "left",
  disabled: false,
  loading: false,
});

// Slots
const slots = useSlots();

// --------------------------------------------------
// A11y: si no hay texto ni slot, el ariaLabel se vuelve obligatorio
// --------------------------------------------------
const computedAriaLabel = computed(() => {
  if (props.label) return props.label;
  if (slots.default) return undefined;
  return props.ariaLabel ?? "Button";
});

// --------------------------------------------------
// CSS classes
// --------------------------------------------------
const buttonClasses = computed(() => [
  "button",
  `button--${props.variant}`,
  `button--size-${props.size}`,
  {
    "button--icon-only": props.icon && !props.label && !slots.default,
    "button--loading": props.loading,
  },
]);
</script>

<template>
  <button
    :class="buttonClasses"
    :disabled="disabled || loading"
    :aria-label="computedAriaLabel"
  >
    <!-- Spinner -->
    <span v-if="loading" class="button__spinner" />

    <!-- Icono izquierda -->
    <span
      v-if="icon && !loading && iconPosition === 'left'"
      class="button__icon"
    >
      <slot name="icon" />
    </span>

    <!-- Texto o slot -->
    <span v-if="!loading" class="button__label">
      <slot v-if="slots.default" />
      <span v-else-if="label">{{ label }}</span>
    </span>

    <!-- Icono derecha -->
    <span
      v-if="icon && !loading && iconPosition === 'right'"
      class="button__icon"
    >
      <slot name="icon" />
    </span>
  </button>
</template>

<style scoped>


/* ------------------------------------------------------
   Base
------------------------------------------------------ */
.button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: var(--space-2);
  border-radius: var(--radius-md);
  border: none;
  cursor: pointer;
  font-weight: 500;
  white-space: nowrap;
  transition: background 0.2s ease, border-color 0.2s ease, opacity 0.2s ease;
}

/* Responsive: móvil → full width */
@media (max-width: 480px) {
  .button {
    width: 100%;
  }
}



/* ------------------------------------------------------
   Tamaños
------------------------------------------------------ */
.button--size-sm {
  font-size: var(--font-size-xs);
  padding: var(--space-1-5) var(--space-3);
}

.button--size-md {
  font-size: var(--font-size-md);
  padding: var(--space-2) var(--space-4);

}

.button--size-lg {
  font-size: var(--font-size-md);
  padding: var(--space-3) var(--space-5);
}

/* Icon-only */
.button--icon-only {
  padding: var(--space-2);
  width: 40px;
  height: 40px;
  justify-content: center;
}

/* ------------------------------------------------------
   Variantes
------------------------------------------------------ */
.button--primary {
  background: var(--color-primary);
  color: var(--color-on-primary);
}
.button--primary:hover {
  background: var(--color-primary-hover);
}

.button--secondary {
  background: var(--color-secondary);
  color: var(--color-on-secondary);
}
.button--secondary:hover {
  background: var(--color-secondary-hover);
}

.button--outline {
  background: transparent;
  border: 1px solid var(--color-border);
  color: var(--color-text);
}
.button--outline:hover {
  background: var(--color-surface-hover);
}

/* ------------------------------------------------------
   Loading
------------------------------------------------------ */
.button--loading {
  pointer-events: none;
  opacity: 0.7;
}

.button__spinner {
  width: 18px;
  height: 18px;
  border: 2px solid var(--color-border);
  border-top-color: var(--color-primary);
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
    padding: 0.625rem 0.625rem;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

/* ------------------------------------------------------
   Iconos
------------------------------------------------------ */
.button__icon {
  display: flex;
  align-items: center;
}

/* ------------------------------------------------------
   Disabled
------------------------------------------------------ */
.button:disabled {
  opacity: 0.55;
  cursor: not-allowed;
}
</style>
