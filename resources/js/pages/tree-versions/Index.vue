<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

interface TreeVersionRow {
    id: number;
    league_name: string;
    version: string;
    is_active: boolean;
    fetched_at: string | null;
}

defineProps<{
    versions: TreeVersionRow[];
}>();

/**
 * Returns a parsed data for when the tree was fetched.
 * @param value
 */
function formatDate(value: string | null): string {
    if (!value) return 'Not fetched';
    return new Date(value).toLocaleDateString('en-GB', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
}

const league = ref('');
const version = ref('');
const fetching = ref(false);
const fetchErrors = reactive<{ league?: string; version?: string }>({});

function submitFetch() {
    fetching.value = true;
    fetchErrors.league = undefined;
    fetchErrors.version = undefined;

    router.post(
        '/tree-versions',
        { league: league.value, version: version.value },
        {
            preserveScroll: true,
            onError: (errors) => {
                fetchErrors.league = errors.league;
                fetchErrors.version = errors.version;
            },
            onSuccess: () => {
                league.value = '';
                version.value = '';
            },
            onFinish: () => {
                fetching.value = false;
            },
        },
    );
}

const activatingId = ref<number | null>(null);

function activate(id: number) {
    activatingId.value = id;

    router.post(
        `/tree-versions/${id}/activate`,
        {},
        {
            preserveScroll: true,
            onFinish: () => {
                activatingId.value = null;
            },
        },
    );
}
</script>

<template>
    <Head title="Tree Version Management" />

    <div class="p-6">
        <div class="mx-auto flex max-w-4xl flex-col gap-8">
            <!-- Tree Management Header Section -->
            <header class="space-y-2">
                <h1 class="text-lg font-semibold tracking-[0.25em] text-poe-gold uppercase">Tree Version Management</h1>
                <div class="h-px w-full bg-gradient-to-r from-transparent via-poe-gold/50 to-transparent"/>
                <p class="text-sm text-poe-text-muted">Fetch and activate passive skill tree data pulled from GGG's
                    <a href="https://github.com/grindinggear/skilltree-export/releases" target="_blank" rel="noopener noreferrer" class="text-poe-gold underline decoration-poe-gold/40 underline-offset-4 hover:text-poe-gold-bright">
                        official export repo
                    </a>.
                    The active version is served to every template.
                </p>
            </header>

            <!-- Fetch new version panel -->
            <section class="rounded-lg border border-poe-border-bright bg-poe-panel/90 p-6 shadow-poe-panel">
                <h2 class="mb-4 text-xs font-semibold tracking-[0.2em] text-poe-gold/90 uppercase">Fetch New Version</h2>

                <form @submit.prevent="submitFetch" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                    <div class="grid flex-1 gap-2">
                        <Label for="league" class="text-poe-text-muted">League Name</Label>
                        <Input id="league" v-model="league" placeholder="Settlers of Kalguur" required class="border-poe-border-bright bg-poe-panel text-poe-text-bright placeholder:text-poe-text-placeholder focus-visible:border-poe-gold focus-visible:ring-poe-gold/40" />
                        <InputError :message="fetchErrors.league" />
                    </div>

                    <div class="grid flex-1 gap-2">
                        <Label for="version" class="text-poe-text-muted">Version Tag</Label>
                        <Input id="version" v-model="version" placeholder="3.25.0" required class="border-poe-border-bright bg-poe-panel font-mono text-poe-text-bright placeholder:text-poe-text-placeholder focus-visible:border-poe-gold focus-visible:ring-poe-gold/40" />
                        <InputError :message="fetchErrors.version" />
                    </div>

                    <Button type="submit" :disabled="fetching" class="h-9 bg-poe-gold font-semibold tracking-wide text-black uppercase hover:bg-poe-gold-bright disabled:opacity-50">
                        {{ fetching ? 'Fetching...' : 'Fetch Data' }}
                    </Button>
                </form>
            </section>

            <!-- Versions list -->
            <section class="space-y-3">
                <h2 class="text-xs font-semibold tracking-[0.2em] text-poe-gold/90 uppercase">Recorded Versions</h2>

                <p v-if="versions.length === 0" class="rounded-lg border border-dashed border-poe-border-bright bg-poe-panel/60 p-6 text-center text-sm text-poe-text-muted">
                    No tree data has been recorded yet. Fetch a version above to get started.
                </p>

                <ul v-else class="flex flex-col gap-2">
                    <li v-for="v in versions" :key="v.id" class="flex items-center justify-between gap-4 rounded-lg border bg-poe-panel/90 px-4 py-3 transition-colors"
                        :class="v.is_active? 'border-poe-green/60 ring-1 ring-poe-green/30' : 'border-poe-border-muted'">
                        <div class="flex min-w-0 items-center gap-3">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="truncate font-medium" :class="v.is_active ? 'font-semibold text-poe-text-brightest' : 'text-poe-text-bright'">
                                        {{ v.league_name }}
                                    </span>
                                    <Badge variant="outline" class="border-poe-border-bright font-mono text-xs text-poe-gold">{{ v.version }}</Badge>
                                </div>
                                <p class="text-xs text-poe-text-muted">Fetched {{ formatDate(v.fetched_at) }}</p>
                            </div>
                        </div>

                        <div class="flex shrink-0 items-center gap-3">
                            <Badge v-if="v.is_active" class="gap-1.5 border-poe-green/50 bg-poe-green/20 text-poe-green-bright" variant="outline">
                                <span class="size-1.5 rounded-full bg-poe-green-bright" />Active
                            </Badge>
                            <Button v-else type="button" :disabled="activatingId === v.id" size="sm" variant="outline" @click="activate(v.id)"
                                class="border-poe-border-bright text-xs tracking-wide text-poe-gold uppercase hover:bg-poe-gold/10 hover:text-poe-gold-bright disabled:opacity-50">
                                Activate
                            </Button>
                        </div>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</template>
