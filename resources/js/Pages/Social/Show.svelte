<script>
    import Layout from '../Shared/Layout.svelte';
    import { onMount } from 'svelte';
    let { post } = $props();

    onMount(() => {
        console.log(post);
    });
</script>

<Layout>
    <h1>{post.title}</h1>
</Layout>
