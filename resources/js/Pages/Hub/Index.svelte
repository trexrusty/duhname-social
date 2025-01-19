<script>
    import Layout from '../Shared/Layout.svelte'
    import { page } from '@inertiajs/svelte'
    import { router } from '@inertiajs/svelte'
    import axios from 'axios'

</script>

<Layout>
    <div>
        <h1>Hubs</h1>
    </div>
</Layout>
<WhenVisible
always
params={{
    data: {
        page: PaginationPosts.current_page + 1,
    },
    only: ['posts', 'PaginationPosts'],
    preserveUrl: true
}}
>
<h1 class="text-white text-center text-2xl mt-4">If you see this, the posts are not loading</h1>
</WhenVisible>
