<script setup lang="ts">
import Logo from '@/components/branding/Logo.vue';
import Button from '@/components/ui/buttons/Button.vue';
import ThemeToggle from '@/components/ui/controls/ThemeToggle.vue';
import Card from '@/components/ui/data-display/Card.vue';
import Input from '@/components/ui/forms/Input.vue';
import Icon from '@/components/ui/icons/Icon.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login.post'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
<template>
    <GuestLayout>
        <Card>
            <template #header>
                <div class="flex items-center justify-center">
                    <Logo src="/images/logo.png" size="lg" label="CHECKPOINT" label-position="bottom" />
                </div>
            </template>
            <p>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsa beatae magnam vel ratione explicabo aliquid quam, quaerat rem
                consequuntur! Unde debitis ipsum quisquam porro enim vel eum accusantium. Harum, facere!
            </p>

            <form @submit.prevent="submit">
                <Input disabled v-model="form.email" label="Usuario" placeholder="user@example.com" type="email" />
                <Input v-model="form.password" label="Contraseña" placeholder="contraseña" type="password" />
                <Button :loading="form.processing" label="hola" icon disabled>
                    <template #icon><Icon /> </template>
                </Button>
            </form>
            <template #footer>
                <ThemeToggle />
            </template>
        </Card>
        <div class="py-1.5"></div>

        <Card variant="secondary">
            <template #header>
                <div class="flex items-center justify-center">
                    <Logo src="/images/logo.png" size="lg" label="CHECKPOINT" label-position="bottom" />
                </div>
            </template>
            <p>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsa beatae magnam vel ratione explicabo aliquid quam, quaerat rem
                consequuntur! Unde debitis ipsum quisquam porro enim vel eum accusantium. Harum, facere!
            </p>

            <form @submit.prevent="submit">
                <Input disabled v-model="form.email" label="Usuario" placeholder="user@example.com" type="email" />
                <Input v-model="form.password" label="Contraseña" placeholder="contraseña" type="password" />
                <Button :loading="form.processing" label="contraseña" variant="secondary" icon disabled>
                    <template #icon><Icon /> </template>
                </Button>
            </form>

            <template #footer>
                <ThemeToggle />
            </template>
        </Card>
        <div class="py-1.5"></div>
        <Card variant="outline">
            <template #header>
                <div class="flex items-center justify-center">
                    <Logo src="/images/logo.png" size="lg" label="CHECKPOINT" label-position="bottom" />
                </div>
            </template>
            <p>
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsa beatae magnam vel ratione explicabo aliquid quam, quaerat rem
                consequuntur! Unde debitis ipsum quisquam porro enim vel eum accusantium. Harum, facere!
            </p>

            <form @submit.prevent="submit">
                <Input disabled v-model="form.email" label="Usuario" placeholder="user@example.com" type="email" />
                <Input v-model="form.password" label="Contraseña" placeholder="contraseña" type="password" />
                <Button :loading="form.processing"> Iniciar sesión</Button>
            </form>
            <template #footer>
                <ThemeToggle />
            </template>
        </Card>
    </GuestLayout>
</template>
