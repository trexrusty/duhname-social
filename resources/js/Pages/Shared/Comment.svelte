<script>
    import { inertia } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'
    import axios from 'axios'
    import { likeAuth } from '../../libs/stores/LikeAuth'
    import CommentLike from './Form/Comment/Like.svelte';

    let { comment } = $props()


    let likes_count = $state(comment.likes_count)
    let has_liked = $state(comment.has_liked)

    let has_reported = $state(false)

    function reportComment() {
        axios.post(`/api/report/comment/${comment.id}`)
        .then(response => {
            has_reported = true
        })
        .catch(error => {
            console.error('Error reporting comment:', error)
        })
    }
</script>

<div class="border border-gray-500 container mx-auto max-w-xl bg-secondary shadow-md text-white">
    <div class="flex items-center justify-between px-4 pt-2">
        <div class="flex items-center justify-start">
            <img src="http://localhost:9000/local/user_icons/{comment.user.id}.png" alt="User Icon" class="w-10 h-10 rounded-full">
            <div class="flex flex-col justify-start">
                <h1 class="text-sm text-white">{comment.user?.username ?? 'Unknown User'}</h1>
                <a use:inertia={{ href: '/profile/' + comment.user?.tag, preserveState: true }} href={`/profile/${comment.user?.tag}`} class="text-xs text-white hover:text-gray-400 hover:underline">duh:{comment.user?.tag ?? 'Unknown User'}</a>
            </div>
        </div>
        <div class="flex items-center justify-end">
            {#if has_reported === false}
                <button onclick={reportComment} class="flex text-xs text-white hover:text-gray-400 hover:underline justify-end">Report</button>
            {/if}
            {#if has_reported}
                <p class="text-xs text-white">Reported</p>
            {/if}
        </div>
    </div>
    <div class="text-base text-white break-words whitespace-normal px-4 pb-2 mb-2 pt-2">{comment.content}</div>
    <div class="border-b border-gray-500"></div>
    <div class="flex items-center justify-between px-4">
        <a href={`/social/${comment.id}`} use:inertia={{ prefetch: 'click' }} class="text-white justify-start hover:text-blue-500">
            <p class="text-sm text-white text-center">{comment.comments_count ?? 0}</p>
        </a>
        <div class="flex items-center justify-end pr-4">
            <CommentLike has_liked={has_liked} likes_count={likes_count} comment_id={comment.id}/>
        </div>
    </div>
</div>

