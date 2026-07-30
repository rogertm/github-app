<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import GithubUserController from '@/actions/App/Http/Controllers/Dashboard/GithubUserController';
import Heading from '@/components/Heading.vue';

/**
 * Estructura de un repositorio tal como se serializa desde
 * app/Models/Repository.php
 */
type Repository = {
    id: number;
    name: string;
    full_name: string;
    html_url: string | null;
    description: string | null;
    language: string | null;
    is_visible: boolean;
    github_created_at: string;
    github_updated_at: string;
    topics: string[];
};

/**
 * Estructura del recurso GithubUser (con repositorios cargados)
 * tal como se envía desde GithubUserController@show
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
    repositories: Repository[];
};

type Props = {
    githubUser: GithubUser;
};

const props = defineProps<Props>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Github Users',
                href: GithubUserController.index(),
            },
        ],
    },
});

const dateFormated = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });
}
</script>

<template>
    <Head :title="`Github User: ${props.githubUser.name ?? props.githubUser.github_login}`" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

        <div class="space-y-6">
            <Heading
                :title="props.githubUser.name ?? props.githubUser.github_login"
                :description="`${props.githubUser.repositories.length} repositorios`"
            />

            <div v-if="props.githubUser.repositories.length === 0" class="rounded-lg border p-8 text-center">
                <p class="text-sm text-muted-foreground">
                    El usuario {{ props.githubUser.name ?? props.githubUser.github_login }} no tiene repositorios
                </p>
            </div>

            <div v-else class="overflow-hidden rounded-lg border border-border">
                <div
                    v-for="repository in props.githubUser.repositories"
                    :key="repository.id"
                    class="flex items-center justify-between gap-4 border-b border-border p-4 last:border-b-0"
                >

                    <section class="text-gray-400 body-font overflow-hidden">
                        <div class="container px-3 py-12 mx-auto">
                            <div class="flex -my-8">

                                <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                                    <span class="font-semibold title-font text-white">{{ repository.language }}</span>
                                    <div class="flex flex-wrap mb-4">
                                        <span class="mt-1 mb-1">
                                            <span class="text-gray-300 mr-2">Created at:</span>
                                            <span class="text-gray-500">{{ dateFormated(repository.github_created_at) }}</span>
                                        </span>
                                        <span class="mb-1">
                                            <span class="text-gray-300 mr-2">Updated at:</span>
                                            <span class="text-gray-500">{{ dateFormated(repository.github_updated_at) }}</span>
                                        </span>
                                    </div>
                                    <div v-if="repository.topics.length !== 0">
                                        <span class="font-semibold title-font text-white mb-5">Topics:</span>
                                        <div class="flex flex-wrap justify-start">
                                            <div
                                                v-for="topic in repository.topics"
                                                :key="topic"
                                                class="mr-3 mb-2"
                                            >
                                                <code class="mt-1 text-gray-300 code  text-sm">[{{ topic }}]</code>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="md:flex-grow">
                                    <h2 class="text-2xl font-medium text-white title-font mb-2">{{ repository.name }}</h2>
                                    <p class="leading-relaxed">{{ repository.description }}</p>
                                    <a
                                        :href="repository.html_url"
                                        class="text-indigo-400 inline-flex items-center mt-4"
                                    >
                                        View source code
                                        <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </section>

                </div>
            </div>

            <!-- Aquí iteras props.githubUser.repositories -->

        </div>
    </div>
</template>
