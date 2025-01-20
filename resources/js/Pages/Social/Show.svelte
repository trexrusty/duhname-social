<script>
    import Layout from '../Shared/Layout.svelte';
    import Post from '../Shared/Post.svelte';
    import { page } from '@inertiajs/svelte'
    import { inertia } from '@inertiajs/svelte'
    import { likeAuth } from '../../libs/stores/LikeAuth'
    import { useForm } from '@inertiajs/svelte'
    import Comment from '../Shared/Comment.svelte';
    import { onMount } from 'svelte';
    let { social_post } = $props();

    let like_auth = $state(false);
    likeAuth.subscribe(value => {
           like_auth = value;
       });

    let comments = $state([]);

    async function fetchComments() {
        try {
            const response = await axios.get(`/api/social/${social_post.id}/comments`);
            comments = response.data;
        } catch (error) {
            console.error('Error fetching comments:', error);
        }
    }


    onMount(() => {
        fetchComments();
    });


    let PostForm = useForm({
        _token: $page.props.csrf_token,
        content: '',
        post_id: social_post.id,
    })

    function submit(e) {
        e.preventDefault();
        $PostForm.post(`/social/${social_post.id}/comment`, {
            onSuccess: () => {
                $PostForm.reset('content');
                fetchComments();
            },
        });
    }
</script>

<Layout>
    <div class="flex flex-col items-center justify-center mt-10">
        <div class="border border-gray-500 bg-secondary container mx-auto max-w-xl">
        </div>
            <Post post={social_post} />
    </div>
    <div class="items-center justify-center container max-w-xl mx-auto ">
        {#if $page.props.auth.user}
            <form onsubmit={submit} id="post-form">
                <div class="flex flex-col items-center justify-center border border-gray-500 shadow-md bg-secondary max-w-xl">
                    <textarea name="content" rows="2" placeholder='What are you thinking about?' class="block w-full text-white bg-secondary resize-none outline-none no-scrollbar p-2 mb-2" bind:value={$PostForm.content}></textarea>
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
    <div class="items-center justify-center container max-w-xl mx-auto ">
        {#if comments.length > 0}
            <div class="flex flex-col items-center justify-center mt-10 w-full">
                <div class="border border-gray-500 bg-secondary w-full">
                    <h1 class="text-white text-2xl font-bold text-center">Comments</h1>
                </div>
                {#each comments as comment}
                    <Comment comment={comment} />
                {/each}
            </div>
        {:else}
            <p class="text-white">No comments yet</p>
        {/if}
    </div>
</Layout>
