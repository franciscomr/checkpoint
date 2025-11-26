<script setup lang="ts">
import { ref } from 'vue'

interface Props {
  modelValue: string | number | null
  type?: string
  label?: string
  placeholder?: string
  error?: boolean | string
  disabled?: boolean
  readonly?: boolean
  size?: 'xs' | 'sm' | 'md' | 'lg'
  variant?: 'default' | 'subtle' | 'outline'
}

const props = withDefaults(defineProps<Props>(), {
  modelValue:null,
  type: 'text',
  disabled:false,
  readonly:false,
  size:'md',
  variant:'default'
});

/* ------------------------------------------
   3) Emitters Tipados
-------------------------------------------*/
const emit = defineEmits<{
  (e: 'update:modelValue', value: string | number | null): void
  (e: 'focus', ev: FocusEvent): void
  (e: 'blur', ev: FocusEvent): void
}>()

/* ------------------------------------------
   4) Refs
-------------------------------------------*/
const inputRef = ref<HTMLInputElement | null>(null)

/* ------------------------------------------
   5) Handlers
-------------------------------------------*/
const onInput = (e: Event) => {
  const target = e.target as HTMLInputElement
  emit('update:modelValue', target.value)
}
</script>

<template>
  <div
    class="input"
    :class="[
      `input--${size ?? 'md'}`,
      `input--${variant ?? 'default'}`,
      {
        'input--disabled': disabled,
        'input--readonly': readonly,
        'input--error': error
      }
    ]"
  >
    <!-- Label -->
    <label v-if="label" class="input__label">
      {{ label }}
    </label>

    <!-- Input Wrapper -->
    <div class="input__wrapper">
      <!-- Leading -->
      <span v-if="$slots.leading" class="input__leading">
        <slot name="leading" />
      </span>

      <!-- Campo -->
      <input
        ref="inputRef"
        class="input__field"
        :type="type ?? 'text'"
        :value="modelValue"
        :placeholder="placeholder"
        :disabled="disabled"
        :readonly="readonly"
        :aria-invalid="error ? 'true' : 'false'"
        @input="onInput"
        @focus="(e) => emit('focus', e)"
        @blur="(e) => emit('blur', e)"
      />

      <!-- Trailing -->
      <span v-if="$slots.trailing" class="input__trailing">
        <slot name="trailing" />
      </span>
    </div>



    <!-- Error -->
    <p v-if="error" class="input__error">
      {{ typeof error === 'string' ? error : 'Campo inválido' }}
    </p>
  </div>
</template>

<style scoped>


/* ------------------------------------------
   Contenedor (100% width)
-------------------------------------------*/
.input {
  display: flex;
  flex-direction: column;
  gap: var(--space-1);
  width: 100%; /* <= Siempre 100% */
}

/* Label */
.input__label {
  font-size: var(--font-size-md);
}

/* Wrapper */
.input__wrapper {
  display: flex;
  align-items: center;
  width: 100%;
  border-radius: var(--radius-md);
  border: 1px solid var(--color-border);
  background-color: var(--color-semi-transparency);



  padding: 0 var(--space-3);
  transition: border-color 0.15s ease;
}

/* Campo */
.input__field {
  flex: 1;
  border: none;
  background: transparent;
  font-size: var(--font-size-md);
  padding: var(--space-2) 0;
  outline: none;
}

/* Iconos */
.input__leading,
.input__trailing {
  display: flex;
  align-items: center;
  opacity: 0.7;
}

/* Hover + Focus */
.input__wrapper:hover {
  border-color: var(--color-border-variant);
}
.input__wrapper:focus-within {
  border-color: var(--color-primary);
}

/* Estados */
.input--disabled .input__wrapper {
  opacity: 0.6;
  pointer-events: none;
}
.input--readonly .input__wrapper {
  background: var(--color-semi-transparency-variant);
}
.input--error .input__wrapper {
  border-color: var(--color-error);
}

/* Mensajes */
.input__error {
  font-size: var(--font-size-xs);
  color: var(--color-error-dark);
}

/* Tamaños */
.input--xs .input__field {
  font-size: var(--font-size-xs);
  padding: var(--space-1) 0;
}
.input--sm .input__field {
  font-size: var(--font-size-sm);
}
.input--lg .input__field {
  font-size: var(--font-size-lg);
  padding: var(--space-3) 0;
}

/* Variantes */
.input--subtle .input__wrapper {
  background: var(--color-surface-alt);
  border-color: transparent;
}
.input--outline .input__wrapper {
  border-width: 2px;
}
</style>
