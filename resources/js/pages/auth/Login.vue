<script setup lang="ts">
import Logo from '@/components/branding/Logo.vue';
import Button from '@/components/ui/buttons/Button.vue';
import Card from '@/components/ui/data-display/Card.vue';
import Input from '@/components/ui/forms/Input.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login.post'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Card alignment="center">
            <template #header>
                <div class="flex items-center justify-center">
                    <Logo src="/images/logo.png" size="lg" label="CHECKPOINT" label-position="bottom" />
                </div>
            </template>

            <div class="">
                <!-- FORM -->
                <form class="login__form" @submit.prevent="submit">
                    <Input v-model="form.email" label="Usuario" placeholder="user@example.com" type="email" :error="form.errors.email" />
                    <Input v-model="form.password" label="Contraseña" placeholder="Abc12345" type="password" />
                    <div class="flex items-end justify-end">
                        <Button :loading="form.processing"> Iniciar sesión</Button>
                    </div>
                </form>
            </div>
        </Card>
    </GuestLayout>
</template>

<style scoped>
.login__form > * {
    padding: 0.125rem 0rem; /* equivalente a p-4 en Tailwind */
}
</style>

<!---

  <Button type="submit" variant="primary" :loading="form.processing" full> Entrar </Button>
-->
