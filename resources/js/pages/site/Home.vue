<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import GithubUserController from '@/actions/App/Http/Controllers/Site/GithubUserController';
import Heading from '@/components/Heading.vue';

/**
 * Estructura mínima del recurso GithubUser tal como se serializa
 * desde el modelo App\Models\GithubUser (ver withCount('repositories')
 * en GithubUserController@index).
 */
type GithubUser = {
    id: number;
    github_login: string;
    name: string | null;
    html_url: string;
    avatar_url: string;
    location: string | null;
    bio: string | null;
    public_repos: number;
    followers: number;
    following: number;
    type: string;
    repositories_count: number;
};

type Props = {
    githubUsers: GithubUser[];
};

const props = defineProps<Props>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Github Users',
                href: GithubUserController.home(),
            },
        ],
    },
});

</script>

<template>
    <Head title="Github Users" />

    <div v-if="props.githubUsers.length === 0" class="rounded-lg border p-8 text-center">
        <p class="text-sm text-muted-foreground">
            No hay usuarios
        </p>
    </div>

    <div v-else class="text-gray-400 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-wrap">
                <div
                    v-for="githubUser in props.githubUsers"
                    :key="githubUser.id"
                    class="p-4 lg:w-1/3"
                >
                    <div class="h-full bg-gray-900 bg-opacity-40 px-8 pt-16 pb-24 rounded-lg overflow-hidden text-center relative">
                        <h2 class="tracking-widest text-xs title-font font-medium text-gray-500 mb-1">{{ githubUser.type }}</h2>
                        <h1 class="title-font sm:text-2xl text-xl font-medium text-white mb-3">
                            {{ githubUser.name ?? githubUser.github_login }}
                        </h1>
                        <p class="leading-relaxed mb-3">{{ githubUser.location }}</p>
                        <p class="leading-relaxed mb-3">{{ githubUser.bio }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
