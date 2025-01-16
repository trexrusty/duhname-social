<script>
    import { onMount } from 'svelte';
    import { inertia, Link } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'


</script>

<svelte:head>
    <title>Inertia Svelte</title>
</svelte:head>

<div class="container mx-auto">
    <header class="">
        <nav class="bg-primary p-4 flex justify-center items-center">
            <div class="flex space-x-4 items-center">
                <a href="/" class="text-white hover:text-gray-300">Home</a>
                {#if $page.props.auth.user}
                    <a href="/logout" class="text-white hover:text-gray-300">Logout</a>
                {:else}
                    <a href="/login" class="text-white hover:text-gray-300">Login</a>
                    <a href="/register" class="text-white hover:text-gray-300">Register</a>
                {/if}
            </div>
        </nav>
    </header>
    <slot />
</div>
