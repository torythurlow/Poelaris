<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLogo from '@/components/AppLogo.vue';
import { Toaster } from '@/components/ui/sonner';
</script>

<template>
    <div
        class="flex min-h-screen flex-col bg-[radial-gradient(ellipse_at_top,_var(--color-poe-void-bright),_var(--color-poe-void)_60%,_black)] text-poe-text"
    >
        <header
            class="flex h-14 shrink-0 items-center gap-4 border-b border-poe-border bg-poe-header px-4"
        >
            <Link href="/tree-versions" class="flex items-center gap-2">
                <AppLogo />
            </Link>
            <nav
                class="ml-auto flex items-center gap-5 text-sm text-poe-text-muted"
            >
                <Link
                    href="/tree-versions"
                    class="transition-colors hover:text-poe-gold"
                    >Tree Versions</Link
                >
            </nav>
        </header>

        <main class="flex-1">
            <slot />
        </main>

        <Toaster />
    </div>
</template>
