<script>
    import Layout from '../Shared/Layout.svelte';
    import { onMount } from 'svelte';
    let { social_post } = $props();

    onMount(() => {
        console.log(social_post);
        console.log(social_post.comments);
    });
</script>

<Layout>
    {#if social_post}
    <div class="flex flex-col items-center justify-center">
        <h1 class="text-white">{social_post.content}</h1>
        <p class="text-white">{social_post.user.username}</p>
    </div>
{:else}
    <p class="text-white">Loading...</p>
{/if}

<div class="flex flex-col items-center justify-center mt-10">
    {#if social_post.comments}
        <h1 class="text-white">Comments</h1>
        {#each social_post.comments as comment}
        <p class="text-white">{comment.content}</p>
        <p class="text-white">{comment.user?.username ?? 'Unknown User'}</p>
        <p class="text-white">{comment.user?.tag ?? 'Unknown User'}</p>
        {/each}
    {:else}
        <p class="text-white">No comments yet</p>
    {/if}
</div>
</Layout>
