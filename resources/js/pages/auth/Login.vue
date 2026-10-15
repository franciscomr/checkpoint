<script setup lang="ts">
import AuthCardLayout from '@/layouts/auth/AuthCardLayout.vue';
import { Head, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import PasswordInput from '@/components/PasswordInput.vue';
import { Checkbox } from '@/components/ui/checkbox';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';


// Props enviadas opcionalmente desde el backend o HandleInertiaRequests
defineProps({
    status: {
        type: String,
        default: null,
    },
})

// Inicialización del formulario reactivo de Inertia
const form = useForm({
    email: '',
    password: '',
    remember: false,
})

// Control local de visibilidad de contraseña


// Función de envío del formulario
const submit = () => {
    form.post(route('login.store'), {
        onFinish: () => {
            // Limpia el campo de contraseña si el intento falla
            form.reset('password')
        },
    })
}

</script>

<template>
    <AuthCardLayout title="iniciar Sesión">
        <form  @submit.prevent="submit">
        <div class="grid gap-6">
             <div class="grid gap-2">
                <Label for="email">Email address</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    v-model="form.email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    placeholder="email@example.com"
                />
                <InputError :message="form.errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="password">Password</Label>    
                <PasswordInput
                    id="password"
                    name="password"
                    v-model="form.password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    placeholder="Password"
                />
                <InputError :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <Label for="remember" class="flex items-center space-x-3">
                    <Checkbox v-model="form.remember" id="remember" name="remember" :tabindex="3" />
                    <span>Remember me</span>
                </Label>
            </div>

            <Button
                type="submit"
                class="mt-4 w-full"
                :tabindex="4"
                :disabled="form.processing"
                data-test="login-button"
            >
                <Spinner v-if="form.processing" />
                Log in
            </Button>
        </div>
        </form>
    </AuthCardLayout>
    </template>
