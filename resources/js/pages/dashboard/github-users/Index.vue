<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import GithubUserController from '@/actions/App/Http/Controllers/Dashboard/GithubUserController';
import Heading from '@/components/Heading.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { useInitials } from '@/composables/useInitials';

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

const { getInitials } = useInitials();

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

const handleDelete = (id: number) => {
    if (!confirm('¿Seguro que quieres eliminar este usuario de GitHub?')) {
        return;
    }

    GithubUserController.destroy(id);
};
</script>

<template>
    <Head title="Github Users" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

        <div class="space-y-6">
            <Heading
                title="Github Users"
                description="Usuarios de GitHub importados junto con sus repositorios"
            />

            <div v-if="props.githubUsers.length === 0" class="rounded-lg border p-8 text-center">
                <p class="text-sm text-muted-foreground">
                    Aún no has importado ningún usuario de GitHub.
                </p>
                <p class="mt-1 text-xs text-muted-foreground">
                    Ejecuta <code>php artisan github:import {username}</code> para importar uno.
                </p>
            </div>

            <div v-else class="overflow-hidden rounded-lg border border-border">
                <div
                    v-for="githubUser in props.githubUsers"
                    :key="githubUser.id"
                    class="flex items-center justify-between gap-4 border-b border-border p-4 last:border-b-0"
                >
                    <div class="flex items-center gap-4">
                        <Avatar class="h-10 w-10 overflow-hidden rounded-full">
                            <AvatarImage :src="githubUser.avatar_url" :alt="githubUser.github_login" />
                            <AvatarFallback>
                                {{ getInitials(githubUser.name ?? githubUser.github_login) }}
                            </AvatarFallback>
                        </Avatar>

                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <a
                                    :href="githubUser.html_url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="font-medium hover:underline"
                                >
                                    {{ githubUser.name ?? githubUser.github_login }}
                                </a>
                                <span class="text-sm text-muted-foreground">
                                    @{{ githubUser.github_login }}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-2 text-xs text-muted-foreground">
                                <Badge variant="secondary">
                                    {{ githubUser.repositories_count }} repos
                                </Badge>
                                <span v-if="githubUser.location">{{ githubUser.location }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <Button variant="outline" size="sm" as-child>
                            <Link :href="GithubUserController.show(githubUser.id)">
                                Ver
                            </Link>
                        </Button>
                        <Button
                            variant="destructive"
                            size="sm"
                            @click="handleDelete(githubUser.id)"
                        >
                            Eliminar
                        </Button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
