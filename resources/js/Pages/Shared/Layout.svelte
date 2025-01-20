<script>
    import { onMount } from 'svelte';
    import { inertia, Link } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'
    import { postState } from '../../libs/stores/Poststate'
    import { router } from '@inertiajs/svelte'
    let { children } = $props()

    router.on('navigate', (event) => {
        const newPath = event.detail.page.url;
        // Only clear if not navigating to home or a social post
        if (!newPath.startsWith('/social/') && newPath !== '/') {
            postState.clear();
        }
    });
</script>

<svelte:head>
    <title>Duhname</title>
</svelte:head>

<main>
    <div class="container mx-auto">
        <header class="">
            <nav class="bg-primary p-4 flex justify-center items-center">
            <div class="flex space-x-4 items-center">
                <a href="/" class="text-white hover:text-gray-300 " use:inertia={{ prefetch: 'click' }} >Home</a>
                {#if $page.props.auth.user}
                    <div class="flex space-x-4 items-center">
                        <img src="http://localhost:9000/local/user_icons/{$page.props.auth.user.id}.png" alt="User Icon" class="w-10 h-10 rounded-full">
                        <a href="/hub" class="text-white hover:text-gray-300" use:inertia={{ prefetch: 'click' }}>Hub</a>
                    </div>
                    <button use:inertia={{ href: '/logout', method: 'delete' }} class="text-white hover:text-gray-300">Logout</button>
                {:else}
                    <a href="/login" class="text-white hover:text-gray-300" use:inertia={{ prefetch: 'click' }}>Login</a>
                    <a href="/register" class="text-white hover:text-gray-300" use:inertia={{ prefetch: 'click' }}>Register</a>
                {/if}
                </div>
            </nav>
        </header>
        {@render children()}
    </div>
</main>


