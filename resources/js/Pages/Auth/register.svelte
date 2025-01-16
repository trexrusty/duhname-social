<script>
    import Layout from '../Shared/Layout.svelte';
    import { useForm } from '@inertiajs/svelte'

    const form = useForm({
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
        <input type="text" id="username" name="username" bind:value={$form.username} />
        <input type="text" id="tag" name="tag" bind:value={$form.tag} />
        <input type="email" id="email" name="email" bind:value={$form.email} />
        <input type="password" id="password" name="password" bind:value={$form.password} />
        <input type="password" id="password_confirmation" name="password_confirmation" bind:value={$form.password_confirmation} />
        <button type="submit">Register</button>
    </form>
    <pre class="mt-4 p-4 bg-gray-100 rounded text-black">
        {JSON.stringify($form, null, 2)}
    </pre>
</Layout>
