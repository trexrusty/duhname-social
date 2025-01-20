<script>
    import Heart from '../Icon/Heart.svelte'
    import { likeAuth } from '../../../libs/stores/LikeAuth'
    import { postState } from '../../../libs/stores/Poststate'
    import axios from 'axios'
    import { page } from '@inertiajs/svelte'
    let { has_liked, likes_count, post_id } = $props()

    function likePost(event) {
        event.preventDefault();
        axios.post('/post/like/' + post_id, {
            _token: $page.props.csrf_token,
            post_id: post_id,
            preserveScroll: true,
        }).then(response => {
            has_liked = response.data.has_liked;
            likes_count = response.data.likes_count;
            postState.updateLike(post_id, has_liked, likes_count);
        }).catch(error => {
            if (error.response.status === 401) {
                likeAuth.set(true)
                setTimeout(() => {
                    likeAuth.set(false);
                }, 5000);
            }
        });
    }
</script>



<button class="flex items-center pl-1 mt-2 text-white rounded mb-2" onclick={likePost} >
    <Heart color={has_liked ? 'red' : 'white'} />
    <span class="ml-1">{likes_count}</span>
</button>
