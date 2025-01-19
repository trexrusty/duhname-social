<script>
    import Layout from '../Shared/Layout.svelte';
    import { useForm } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'

    const form = useForm({
        _token: $page.props.csrf_token,
        username: '',
        tag: '',
        email: '',
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
    <h1 class="text-2xl font-bold">Register</h1>
    <form onsubmit={submit}>
        {#if $form.errors.username}
            <p class="text-red-500">{$form.errors.username}</p>
        {/if}
        <input class="border border-gray-500 rounded-md p-2 bg-secondary text-white focus:outline-none hover:outline-none" type="text" id="username" name="username" bind:value={$form.username} />
        <input class="border border-gray-500 rounded-md p-2 bg-secondary text-white focus:outline-none hover:outline-none" type="text" id="tag" name="tag" bind:value={$form.tag} />
        <input class="border border-gray-500 rounded-md p-2 bg-secondary text-white focus:outline-none hover:outline-none" type="email" id="email" name="email" bind:value={$form.email} />
        <input class="border border-gray-500 rounded-md p-2 bg-secondary text-white focus:outline-none hover:outline-none" type="password" id="password" name="password" bind:value={$form.password} />
        <input class="border border-gray-500 rounded-md p-2 bg-secondary text-white focus:outline-none hover:outline-none" type="password" id="password_confirmation" name="password_confirmation" bind:value={$form.password_confirmation} />
        <button type="submit">Register</button>
    </form>
    <pre class="mt-4 p-4 bg-black rounded text-white">
        {JSON.stringify($form, null, 2)}
    </pre>
</Layout>
