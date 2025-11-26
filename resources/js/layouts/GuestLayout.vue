<template>
    <div class="guest-layout">
        <main class="content">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.guest-layout {
    display: grid;
    place-items: center;
    min-height: 100vh;
    padding: 1rem;
    background-color: var(--color-background);
}
.content {
    width: 100%;
    max-width: 480px;
}
</style>
