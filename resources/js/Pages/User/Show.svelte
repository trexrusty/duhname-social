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
    <div class="profile-container">
        <div class="profile-header">
            <h1 class="username">{user.username}</h1>
            <h2 class="user-id">User ID: {user.id}</h2>
        </div>
        <div class="profile-stats">
            <div class="stat">
                <h3>Following: <span class="stat-count">{following_count}</span></h3>
            </div>
            <div class="stat">
                <h3>Followers: <span class="stat-count">{followers_count}</span></h3>
            </div>
        </div>
        <div class="profile-actions">
            {#if user.id !== $page.props.auth.user.id}
                <button class="follow-button" onclick={() => follow(user)}>
                    {is_following ? 'Unfollow' : 'Follow'}
                </button>
            {:else}
                <a class="edit-profile-link" href={`/edit-profile`}>Edit Profile</a>
            {/if}
        </div>
        <button class="fetch-user-button" onclick={fetchUser}>Refresh Profile</button>
    </div>
    {:else}
    <div class="loading-container">
        <p>Loading...</p>
    </div>
    {/if}
</Layout>
