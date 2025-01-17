<script>
    let { post } = $props()
</script>

<div class="border border-gray-500 container mx-auto mb-5 max-w-md bg-slate-00 rounded-lg shadow-md p-6 text-white">
    <div class="flex items-center justify-center">
        <p class="text-sm text-white">{post.user?.tag ?? 'Unknown User'}</p>
    </div>
    <p class="text-sm text-white">{post.content}</p>
</div>
