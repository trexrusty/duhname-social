<script>
    import Layout from '../Shared/Layout.svelte';
    import { page } from '@inertiajs/svelte'
    import { inertia } from '@inertiajs/svelte'
    import { onMount } from 'svelte'
    import axios from 'axios'

    let user = $state();

    let is_following = $state(false)
    let following_count = $state(0)
    let followers_count = $state(0)

    let userTag = $state(window.location.pathname.split('/').pop())


    async function fetchUser() {
        let response = await axios.get(`/api/profile/${userTag}`);
        user = response.data.user;
        is_following = response.data.is_following;
        following_count = response.data.following_count;
        followers_count = response.data.followers_count;
        console.log(response.data);
    }

    async function follow(user) {
        let response = await axios.post(`/api/follow/${user.id}`);
        is_following = response.data.is_following;
        following_count = response.data.following_count;
        followers_count = response.data.followers_count;
    }

    onMount(() => {
        fetchUser();
    });


</script>
<Layout>
    {#if user}
    <div>
        <h1>{user.username}</h1>
        <h1>{user.id}</h1>
        <h1>{following_count}</h1>
        <h1>{followers_count}</h1>
        {#if user.id !== $page.props.auth.user.id}
                <button onclick={() => follow(user)}>
                {is_following ? 'Unfollow' : 'Follow'}
                </button>
        {:else}
                <a href={`/edit-profile`}>Edit Profile</a>
        {/if}
        <button onclick={fetchUser}>Fetch User</button>

    </div>
    {:else}
    <p>Loading...</p>
    {/if}
</Layout>
