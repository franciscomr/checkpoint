<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    tenant: {
        type: Object,
        required: true,
    },
    stats: {
        type: Object,
        required: true,
    },
})

const page = usePage()
const user = computed(() => page.props.auth?.user)
</script>

<template>
    <Head title="Dashboard" />

    <div class="min-h-screen bg-slate-50 dark:bg-slate-900">
        <!-- Navegación Superior -->
        <nav class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex items-center gap-4">
                        <span class="rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-white">
                            {{ tenant.name }}
                        </span>
                        <h1 class="text-lg font-semibold text-slate-900 dark:text-white">
                            Asset Management (ITIL)
                        </h1>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="text-sm text-slate-600 dark:text-slate-300">
                            {{ user?.name }} ({{ user?.email }})
                        </span>
                        <form method="POST" :action="route('logout')">
                            <button
                                type="submit"
                                class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-700"
                            >
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contenido Principal -->
        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <!-- Bienvenida -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                    Panel de Control del Espacio de Trabajo
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Resumen general del ciclo de vida de los activos en {{ tenant.domain }}
                </p>
            </div>

            <!-- Tarjetas de Métricas (Ciclo de Vida ITIL) -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Activos Totales -->
                <div class="overflow-hidden rounded-xl bg-white p-6 shadow-sm border border-slate-200 dark:border-slate-800 dark:bg-slate-800">
                    <div class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        Total Activos
                    </div>
                    <div class="mt-2 text-3xl font-extrabold text-slate-900 dark:text-white">
                        {{ stats.total_assets }}
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Hardware, Software y Mobiliario</p>
                </div>

                <!-- En Uso -->
                <div class="overflow-hidden rounded-xl bg-white p-6 shadow-sm border border-slate-200 dark:border-slate-800 dark:bg-slate-800">
                    <div class="text-xs font-medium uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                        En Uso
                    </div>
                    <div class="mt-2 text-3xl font-extrabold text-slate-900 dark:text-white">
                        {{ stats.in_use }}
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Asignados a empleados</p>
                </div>

                <!-- En Mantenimiento -->
                <div class="overflow-hidden rounded-xl bg-white p-6 shadow-sm border border-slate-200 dark:border-slate-800 dark:bg-slate-800">
                    <div class="text-xs font-medium uppercase tracking-wider text-amber-600 dark:text-amber-400">
                        Mantenimiento
                    </div>
                    <div class="mt-2 text-3xl font-extrabold text-slate-900 dark:text-white">
                        {{ stats.maintenance }}
                    </div>
                    <p class="mt-1 text-xs text-slate-500">En reparación o revisión</p>
                </div>

                <!-- Usuarios Activos -->
                <div class="overflow-hidden rounded-xl bg-white p-6 shadow-sm border border-slate-200 dark:border-slate-800 dark:bg-slate-800">
                    <div class="text-xs font-medium uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                        Usuarios del Tenant
                    </div>
                    <div class="mt-2 text-3xl font-extrabold text-slate-900 dark:text-white">
                        {{ stats.total_users }}
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Filtrados por TenantScope</p>
                </div>
            </div>
        </main>
    </div>
</template>