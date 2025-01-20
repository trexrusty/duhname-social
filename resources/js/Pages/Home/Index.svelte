<script>
    import axios from 'axios'
    import Layout from '../Shared/Layout.svelte'
    import { useForm } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'
    import { WhenVisible } from '@inertiajs/svelte'
    import Post from '../Shared/Post.svelte'
    import { likeAuth } from '../../libs/stores/LikeAuth'
    import { usePoll } from '@inertiajs/svelte'
    import { postState } from '../../libs/stores/Poststate'
    import { onMount } from 'svelte'

    let { posts: initialPosts, last_post_id: initialLastPostId } = $props()

    let startpolling = $state(false)
    let like_auth = $state(false);

    let posts = $state([]);
    let lastPostId = $state();

    onMount(() => {
        // Initialize store with Inertia props
        postState.initialize(initialPosts, initialLastPostId);
    });
    postState.subscribe((value) => {
        posts = value.posts;
        lastPostId = value.lastPostId;
    });

    likeAuth.subscribe(value => {
        like_auth = value;
    });

    const PostForm = useForm({
        _token: $page.props.csrf_token,
        content: '',
    })

    function testing() {
        axios.get('/post', {
            params: {
                end_id: lastPostId,
            },
        })
        .then(response => {
            const newPosts = response.data.data;
            const newLastPostId = newPosts.length < 10 ? null : response.data.last_post_id;
            postState.addPosts(newPosts, newLastPostId);
        })
        .catch((error) => {
            console.error(error);
        });
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

    <div class="flex flex-col items-center justify-center mb-4">
        <label for="load-more" class="text-white">Live updates</label>
        <input type="checkbox" id="load-more" class="text-white" bind:checked={startpolling}/>
    </div>
    <div class="items-center justify-center container max-w-xl mx-auto ">
        {#if $page.props.auth.user}
            <form onsubmit={submit} id="post-form">
                <div class="flex flex-col items-center justify-center border border-gray-500 shadow-md bg-secondary max-w-xl">
                    <textarea name="content" placeholder='What are you thinking about?' rows="5" class="block w-full text-white bg-secondary resize-none outline-none no-scrollbar p-2 mb-2" bind:value={$PostForm.content}></textarea>
                    <hr class="flex items-center border-t border-gray-500 w-full">
                    <div class="flex items-center justify-center mt-2">
                        <span class="text-white mr-2">{255 - $PostForm.content.length}</span>
                        <button type="submit" class="px-4 py-2 mt-2 bg-secondary text-white rounded hover:bg-tertiary mb-2">Post</button>
                    </div>
                </div>
            </form>
        {:else}
        <div class="items-center justify-center container max-w-xl mx-auto ">
            <div class="flex flex-col items-center justify-center border border-gray-500 shadow-md bg-secondary max-w-xl">
                <p class="{like_auth ? 'text-red-500' : 'text-white'}">Please login to post or like</p>
            </div>
        </div>
        {/if}
    </div>
    {#if posts.length > 0}
        {#each posts as post}
            <Post {post} />
        {/each}
    {:else}
        <p class="text-white text-center">No posts available</p>
    {/if}

    {#if lastPostId}
        <div class="flex items-center justify-center">
            <button class="text-white text-center text-2xl mt-4 bg-secondary p-2 rounded-md hover:bg-tertiary mb-2" onclick={testing}>Load more posts</button>
        </div>
    {:else if lastPostId == null}
        <p class="text-white text-center">No more posts to load</p>
    {/if}
    <p>{JSON.stringify(posts)}</p> <!-- Debug output -->

</Layout>

