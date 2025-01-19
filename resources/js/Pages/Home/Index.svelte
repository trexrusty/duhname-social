<script>
    import axios from 'axios'
    import Layout from '../Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'
    import { WhenVisible } from '@inertiajs/svelte'
    import Post from '../Shared/Post.svelte'
    import { likeAuth } from '../../libs/stores/LikeAuth'
    import { usePoll } from '@inertiajs/svelte'
    import { router } from '@inertiajs/svelte'
    let startpolling = $state(false)
    let { posts, PaginationPosts } = $props()

    console.log(PaginationPosts)

    let like_auth = $state(false);
    likeAuth.subscribe(value => {
           like_auth = value;
       });

    const PostForm = useForm({
        _token: $page.props.csrf_token,
        content: '',
    })

    function loadMorePosts() {
        console.log('loadMorePosts')
        if (PaginationPosts.current_page < PaginationPosts.last_page) {
            router.reload({
                data: {
                    page: PaginationPosts.current_page + 1,
                },
                only: ['posts', 'PaginationPosts'],
                preserveUrl: true
            })
        }
        else {
            console.log('No more posts to load')
        }
    }


    function submit(e) {
        e.preventDefault();
        $PostForm.post('/post', {
            onSuccess: () => {
                $PostForm.reset('content');
            },
        });
    }

    $effect(() => {
        if (startpolling) {
            usePoll(5000)
        }
    })

    window.addEventListener('load', () => {
    window.scrollTo(0, 0);
    });

</script>
<Layout>
    <div class="flex items-center justify-center">
        {#if $page.props.auth.user}
            <form onsubmit={submit} id="post-form">
                <div class="flex flex-col items-center justify-center border border-gray-500 rounded-md shadow-md bg-secondary p-2">
                    <textarea name="content" rows="5"  class="block w-96 text-white bg-secondary resize-none outline-none no-scrollbar" bind:value={$PostForm.content}></textarea>
                </div>
                <div class="flex items-center justify-center mt-2">
                    <span class="text-white mr-2">{255 - $PostForm.content.length}</span>
                    <button type="submit" class="px-4 py-2 mt-2 bg-secondary text-white rounded hover:bg-tertiary mb-2">Post</button>
                </div>
            </form>
        {:else}
            <p class="{like_auth ? 'text-red-500' : 'text-white'}">Please login to post or like</p>
        {/if}
    </div>


    <!-- Debug info -->
    <pre class="text-white">
        Number of posts: {posts?.length ?? 0}
    </pre>
    <div class="flex flex-col items-center justify-center mb-4">
        <label for="load-more" class="text-white">Live updates</label>
        <input type="checkbox" id="load-more" class="text-white" bind:checked={startpolling}/>
    </div>
    {#if posts}
        {#each posts as post}
            <Post post={post} />
        {/each}
    {:else}
        <p class="text-white text-center">No posts available</p>
    {/if}

    {#if PaginationPosts.current_page == PaginationPosts.last_page}
        <h1 class="text-white text-center text-2xl mt-4">If you see this, the posts are not loading</h1>
    {:else}
        <div class="flex items-center justify-center">
            <button class="text-white text-center text-2xl mt-4 bg-secondary p-2 rounded-md hover:bg-tertiary mb-2" onclick={loadMorePosts}>Load more posts</button>
        </div>
    {/if}

</Layout>

