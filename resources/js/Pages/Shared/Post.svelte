<script>
    import { useForm } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'
    import { router } from '@inertiajs/svelte'
    import axios from 'axios'
    import Heart from './Icon/Heart.svelte'

    let { post } = $props()

    let color = 'white'

    function likePost(event) {
        event.preventDefault();
        axios.post('/like/' + post.id, {
            _token: $page.props.csrf_token,
            post_id: post.id,
            preserveScroll: true,
        }).then(response => {
            post = { ...post, likes_count: response.data.likes_count, has_liked: response.data.has_liked };
        }).catch(error => {
            console.error('Error liking post', error);
        });
    }

    function getPostLikes() {
        axios.get('/like/' + post.id).then(response => {
            post = { ...post, likes_count: response.data.likes_count, has_liked: response.data.has_liked };
        }).catch(error => {
            console.error('Error getting post likes', error);
        });
    }

</script>

<div class="border border-gray-500 container mx-auto mb-5 max-w-md bg-slate-00 rounded-lg shadow-md p-6 text-white">
    <div class="flex items-center justify-between">
        <div class="flex items-center justify-start">
            <img src="http://localhost:9000/local/user_icons/{post.user.id}.png" alt="User Icon" class="w-10 h-10 rounded-full">
            <div class="flex flex-col justify-start">
                <h1 class="text-sm text-white">{post.user?.username ?? 'Unknown User'}</h1>
                <p class="text-xs text-white">{post.user?.tag ?? 'Unknown User'}</p>
            </div>
        </div>
    </div>
    <p class="text-sm text-white mt-2">{post.content}</p>
    <div class="flex items-center justify-between mt-6">
        <a href={`/social/${post.id}`} use:inertia={{ prefetch: 'click' }} class="text-white justify-start hover:text-blue-500">
            <p class="text-sm text-white text-center">0</p>
        </a>
        <div class="flex items-center justify-end">
            {#if post.has_liked}
                <button class="pl-1 mt-2 text-white rounded  mb-2" onclick={likePost}><Heart color="red" /> {post.likes_count ?? 0}</button>
            {:else}
                <button class="pl-1 mt-2  text-white rounded  mb-2" onclick={likePost}><Heart color="white" /> {post.likes_count ?? 0}</button>
            {/if}
        </div>
    </div>
</div>

