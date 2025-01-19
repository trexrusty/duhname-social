<script>
    import Layout from '../Shared/Layout.svelte';
    import { useForm } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'
    import Input from '../Shared/Form/Input.svelte'

    let test = $state('test');

    const form = useForm({
        _token: $page.props.csrf_token,
        email: '',
        password: '',
    })

    function submit(e) {
        e.preventDefault();
        $form.post('/login', {
            onSuccess: () => {
                console.log('Login successful');
            },
        });
    }

</script>

<Layout>
    <h1 class="text-2xl font-bold">Login</h1>
    <form onsubmit={submit}>
        {#if $form.errors.email}
            <p class="text-red-500">{$form.errors.email}</p>
        {/if}
        <Input id="email" name="email" bind:value={$form.email} />
        <Input id="password" name="password" bind:value={$form.password} />
        <button type="submit" class="px-4 py-2 mt-2 bg-secondary text-white rounded hover:bg-tertiary mb-2">Login</button>
    </form>
</Layout>
