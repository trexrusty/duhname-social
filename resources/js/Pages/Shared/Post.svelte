<script>
    import { useForm } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'
    import { router } from '@inertiajs/svelte'
    import axios from 'axios'

    let { post } = $props()

    function likePost(event) {
        event.preventDefault();
        axios.post('/like/' + post.id, {
            _token: $page.props.csrf_token,
            post_id: post.id,
            preserveScroll: true,
            preserveState: true,
        }).then(response => {
            getPostLikes();
        }).catch(error => {
            console.error('Error liking post', error);
        });
    }

    function getPostLikes() {
        axios.get('/like/' + post.id).then(response => {
            post = { ...post, likes_count: response.data.likes_count };
        }).catch(error => {
            console.error('Error getting post likes', error);
        });
    }

</script>

<div class="border border-gray-500 container mx-auto mb-5 max-w-md bg-slate-00 rounded-lg shadow-md p-6 text-white">
    <div class="flex items-center justify-center">
        <p class="text-sm text-white">{post.user?.tag ?? 'Unknown User'}</p>
    </div>
    <p class="text-sm text-white">{post.content}</p>
    <form class="flex items-center justify-center" onsubmit={likePost}>
        <button class="px-4 py-2 mt-2 bg-secondary text-white rounded hover:bg-tertiary mb-2" type="submit" use:inertia>{post.likes_count ?? 0} Likes</button>
    </form>
</div>
