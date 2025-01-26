<script>
    import Layout from '../Shared/Layout.svelte';
    import { useForm } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'

    const form = useForm({
        _token: $page.props.csrf_token,
        username: '',
        tag: '',
        password: '',
        password_confirmation: '',
    })

    function submit(e) {
        e.preventDefault();
        $form.post('/register', {
            onSuccess: () => {
                console.log('Registration successful');
            },
        });
    }
</script>

<Layout>
    <div class="flex flex-col items-center justify-center mt-10">
        <h1 class="text-2xl font-bold text-center mb-10">Register</h1>
        <form onsubmit={submit} class="flex flex-col gap-2 max-w-md">
            {#if $form.errors.username}
                <p class="text-red-500">{$form.errors.username}</p>
            {/if}
        <input class="border border-gray-500 rounded-md p-2 bg-secondary text-white focus:outline-none hover:outline-none" type="text" id="username" name="username" placeholder="Username" bind:value={$form.username} />
        <input class="border border-gray-500 rounded-md p-2 bg-secondary text-white focus:outline-none hover:outline-none" type="text" id="tag" name="tag" placeholder="Tag" bind:value={$form.tag} />
        <input class="border border-gray-500 rounded-md p-2 bg-secondary text-white focus:outline-none hover:outline-none" type="password" id="password" name="password" placeholder="Password" bind:value={$form.password} />
            <input class="border border-gray-500 rounded-md p-2 bg-secondary text-white focus:outline-none hover:outline-none" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" bind:value={$form.password_confirmation} />
            <button type="submit">Register</button>
        </form>
    </div>

</Layout>
