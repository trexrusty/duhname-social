<script>
   let { value = $bindable(), ...props } = $props();
</script>

<input type="text" id={props.id} name={props.name} bind:value={value} class="border border-gray-500 rounded-md p-2 bg-secondary text-white focus:outline-none hover:outline-none" {...props} />
