<script>
    import { inertia } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'
    import axios from 'axios'
    import { likeAuth } from '../../libs/stores/LikeAuth'
    import Like from './Form/Like.svelte'
    let { post } = $props()
    import { router } from '@inertiajs/svelte'

    let likes_count = $state(post.likes_count)
    let has_liked = $state(post.has_liked)



</script>

<div class="border-r border-l border-b border-gray-500 container mx-auto max-w-xl bg-secondary shadow-md text-white">
    <div class="flex items-center justify-between px-4 pt-2">
        <div class="flex items-center justify-start">
            <img src="http://localhost:9000/local/user_icons/{post.user.id}.png" alt="User Icon" class="w-10 h-10 rounded-full">
            <div class="flex flex-col justify-start">
                <h1 class="text-sm text-white">{post.user?.username ?? 'Unknown User'}</h1>
                <a use:inertia={{ href: '/profile/' + post.user?.tag, preserveState: true }} href={`/profile/${post.user?.tag}`} class="text-xs text-white hover:text-gray-400 hover:underline">duh:{post.user?.tag ?? 'Unknown User'}</a>
            </div>
        </div>
    </div>
    <div class="text-base text-white break-words whitespace-normal px-4 pb-2 mb-2 pt-2">{post.content}</div>
    <div class="border-b border-gray-500"></div>
    <div class="flex items-center justify-between px-4">
        <a
        href={`/social/${post.id}`}
        use:inertia={{ prefetch: 'hover', preserveState: true, preserveScroll: true }}
        class="text-white justify-start hover:text-blue-500"
        >
        <p class="text-sm text-white text-center">{post.comments_count ?? 0}</p>
        </a>

        <div class="flex items-center justify-end pr-4">
            <Like has_liked={has_liked} likes_count={likes_count} post_id={post.id} />
        </div>
    </div>
</div>

