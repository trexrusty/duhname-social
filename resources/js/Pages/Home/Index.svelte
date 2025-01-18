<script>
    import Layout from '../Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'
    import { WhenVisible } from '@inertiajs/svelte'
    import Post from '../Shared/Post.svelte'
    import { likeAuth } from '../../libs/stores/LikeAuth'
    let { posts } = $props()

    let like_auth = $state(false);

    likeAuth.subscribe(value => {
           like_auth = value;
       });

    const PostForm = useForm({
        _token: $page.props.csrf_token,
        content: '',
    })

    function submit(e) {
        e.preventDefault();
        $PostForm.post('/post', {
            onSuccess: () => {
                $PostForm.reset('content');
            },
        });
    }

</script>

<Layout>
    <div class="flex items-center justify-center">
        {#if $page.props.auth.user}
            <form onsubmit={submit} class="flex flex-col items-center justify-center" id="post-form">
                <input type="text" name="content" class="mt-1 block w-full border-gray-500 rounded-md shadow-sm text-white bg-secondary hover:bg-tertiary" bind:value={$PostForm.content} />
                <span class="text-white">{255 - $PostForm.content.length}</span>
                <button type="submit" class="px-4 py-2 mt-2 bg-secondary text-white rounded hover:bg-tertiary mb-2">Post</button>
            </form>
        {:else}
            <p class="{like_auth ? 'text-red-500' : 'text-white'}">Please login to post or like</p>
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

