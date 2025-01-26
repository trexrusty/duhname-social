<script>
    import Layout from '../Shared/Layout.svelte';
    import { useForm } from '@inertiajs/svelte'
    import { page } from '@inertiajs/svelte'
    import Input from '../Shared/Form/Input.svelte'

    let test = $state('test');

    const form = useForm({
        _token: $page.props.csrf_token,
        tag: '',
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
    <div class="flex flex-col items-center justify-center mt-10">
        <h1 class="text-2xl font-bold text-center mb-10">Login</h1>
        <form onsubmit={submit} class="flex flex-col gap-2 max-w-md">
        {#if $form.errors.tag}
            <p class="text-red-500">{$form.errors.tag}</p>
            {/if}
            <Input type="text" id="tag" name="tag" placeholder="Tag" bind:value={$form.tag} />
            <Input type="password" id="password" name="password" placeholder="Password" bind:value={$form.password} />
            <button type="submit" class="px-4 py-2 mt-2 bg-secondary text-white rounded hover:bg-tertiary mb-2">Login</button>
            </form>
    </div>
</Layout>
