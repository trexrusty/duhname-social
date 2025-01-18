<script>
    import { page } from '@inertiajs/svelte'
    import axios from 'axios'
    import Heart from './Icon/Heart.svelte'
    import { likeAuth } from '../../libs/stores/LikeAuth'
    let { post } = $props()


    function likePost(event) {
        event.preventDefault();
        axios.post('/like/' + post.id, {
            _token: $page.props.csrf_token,
            post_id: post.id,
            preserveScroll: true,
        }).then(response => {
            post = { ...post, likes_count: response.data.likes_count, has_liked: response.data.has_liked };
        }).catch(error => {
            if (error.response.status === 401) {
                likeAuth.set(true)
                setTimeout(() => {
                    likeAuth.set(false); // Reset the store to false after 5 seconds
                }, 5000);
            }
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
    <div class="text-base text-white mt-2 break-words whitespace-normal">{post.content}</div>
    <div class="flex items-center justify-between mt-6">
        <a href={`/social/${post.id}`} use:inertia={{ prefetch: 'click' }} class="text-white justify-start hover:text-blue-500">
            <p class="text-sm text-white text-center">{post.comments_count ?? 0}</p>
        </a>
        <div class="flex items-center justify-end">
            {#if post.has_liked}
                <button class="pl-1 mt-2 text-white rounded mb-2" onclick={likePost}>
                    <Heart color="red" />
                    <span>{post.likes_count ?? 0}</span>
                </button>
            {:else}
                <button class="pl-1 mt-2 text-white rounded mb-2" onclick={likePost}>
                    <Heart color="white" />
                    <span>{post.likes_count ?? 0}</span>
                </button>
            {/if}
        </div>
    </div>
</div>

