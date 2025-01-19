<script>
    import { page } from '@inertiajs/svelte'
    import axios from 'axios'
    import Heart from './Icon/Heart.svelte'
    import { likeAuth } from '../../libs/stores/LikeAuth'
    import Like from './Form/Like.svelte'
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

<div class="border border-gray-500 container mx-auto mb-5 max-w-md bg-slate-00 rounded-lg shadow-md text-white">
    <div class="flex items-center justify-between px-4 pt-2">
        <div class="flex items-center justify-start">
            <img src="http://localhost:9000/local/user_icons/{post.user.id}.png" alt="User Icon" class="w-10 h-10 rounded-full">
            <div class="flex flex-col justify-start">
                <h1 class="text-sm text-white">{post.user?.username ?? 'Unknown User'}</h1>
                <p class="text-xs text-white">{post.user?.tag ?? 'Unknown User'}</p>
            </div>
        </div>
    </div>
    <div class="border-t border-gray-500 my-4"></div>
    <div class="text-base text-white break-words whitespace-normal px-4 pb-2 mb-2">{post.content}</div>
    <div class="border-b border-gray-500"></div>
    <div class="flex items-center justify-between px-4">
        <a href={`/social/${post.id}`} use:inertia={{ prefetch: 'click' }} class="text-white justify-start hover:text-blue-500">
            <p class="text-sm text-white text-center">{post.comments_count ?? 0}</p>
        </a>
        <div class="flex items-center justify-end pr-4">
            <Like has_liked={post.has_liked} likes_count={post.likes_count} post_id={post.id} />
        </div>
    </div>
</div>

