<script>
    import Layout from '../Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'
    import { WhenVisible } from '@inertiajs/svelte'
    import Post from '../Shared/Post.svelte'
    let { posts } = $props()

    const form = useForm({
        _token: $page.props.csrf_token,
        content: '',
    })

    function submit(e) {
        e.preventDefault();
        $form.post('/post', {
            onSuccess: () => {
                console.log('Post created');
            },
        });
    }
</script>

<Layout>
    <div class="flex items-center justify-center">
        {#if $page.props.auth.user}
            <form onsubmit={submit} class="flex flex-col items-center justify-center">
                <input type="text" name="content" class="mt-1 block w-full border-gray-500 rounded-md shadow-sm text-white bg-secondary hover:bg-tertiary" bind:value={$form.content} />
                <button type="submit" class="px-4 py-2 mt-2 bg-secondary text-white rounded hover:bg-tertiary mb-2">Post</button>
            </form>
        {:else}
            <p>Please login to post</p>
        {/if}
    </div>

    <!-- Debug info -->
    <pre class="text-white">
        Number of posts: {posts?.data?.length ?? 0}
    </pre>

    {#if posts.data}
        {#each posts.data as post}
            <Post post={post} />
        {/each}
    {:else}
        <p class="text-white text-center">No posts available</p>
    {/if}

</Layout>

