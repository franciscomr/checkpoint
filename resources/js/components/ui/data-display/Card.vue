<script setup lang="ts">
import { computed, type PropType } from "vue"
import { Link } from "@inertiajs/vue3"

interface Props {
    clickable?: boolean;
    to?: string;
    variant?: 'default' | 'secondary' | 'outline';
    compact?:boolean
}

const props = withDefaults(defineProps<Props>(), {
    clickable: false,
    variant:'default',
    compact:false

});

// Se renderiza como Link si es clickable y hay ruta
const isLink = computed(() => props.clickable && props.to)
const routeName = computed(() => props.clickable && props.to? route(props.to):null)

</script>

<template>
  <component
    :is="isLink ? Link : 'div'"
    :href="isLink ? routeName : undefined"
    class="card"
    :class="[
      `card--${variant}`,
      { 'card--clickable': isLink },
      { 'card--compact': compact }
    ]"
  >
    <!-- HEADER -->
    <div v-if=" $slots.header" class="card__header">
      <slot name="header">
      </slot>
    </div>

    <!-- BODY -->
    <div class="card__body">
      <slot />
    </div>

    <!-- FOOTER -->
    <div v-if="$slots.footer" class="card__footer">
      <slot name="footer">
      </slot>
    </div>
  </component>
</template>

<style scoped>
/* -------------------------------------------------------
   CARD BASE
------------------------------------------------------- */
.card {
  display: flex;
  flex-direction: column;
  width: 100%;
  border-radius: var(--radius-md);
  background-color: var(--color-surface);
  color:var(--color-on-surface);
  border: 1px solid var(--color-border);
  box-shadow: var(--shadow-none);
  overflow: hidden;
  transition: 
    background-color 0.25s ease,
    border-color 0.25s ease,
    box-shadow 0.25s ease,
    transform 0.15s ease;
}

/* -------------------------------------------------------
   CLICKABLE
------------------------------------------------------- */
.card--clickable {
  cursor: pointer;
}

.card--clickable:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-sm);
}

.card--clickable:active {
  transform: scale(0.99);
}

/* -------------------------------------------------------
   VARIANTS
------------------------------------------------------- */


/* Secondary */
.card--secondary {
  background-color: var(--color-surface-variant);
  color: var(--color-on-surface-variant);

}

/* Outline */
.card--outline {
  background-color: transparent;
  border: 1px solid var(--color-border-variant);
  color: var(--color-on-surface-variant);

}



/* -------------------------------------------------------
   COMPACT MODE
------------------------------------------------------- */
.card--compact .card__header,
.card--compact .card__body,
.card--compact .card__footer {
  padding: var(--space-sm);
}

/* -------------------------------------------------------
   HEADER
------------------------------------------------------- */
.card__header {
  padding: var(--space-md);
  font-weight: 600;
  font-size: 1.1rem;
  color: var(--color-text-strong);
}

/* -------------------------------------------------------
   BODY
------------------------------------------------------- */
.card__body {
  padding: var(--space-md);
  color: var(--color-text);
  font-size: 0.95rem;
}

/* -------------------------------------------------------
   FOOTER
------------------------------------------------------- */
.card__footer {
  padding: var(--space-md);
  font-size: 0.9rem;
  color: var(--color-text-soft);
}

/* -------------------------------------------------------
   RESPONSIVE
------------------------------------------------------- */
@media (max-width: 480px) {
  .card__header,
  .card__body,
  .card__footer {
    padding: var(--space-sm);
  }
}
</style>



<!--color-container
const routeName = computed(() => props.clickable && props.to? route(props.to):null)

-->