<script>
    export let message;
    export let isSuccess;

    $:color = isSuccess ? 'bg-teal-100 border border-teal-400 text-teal-700' : 'bg-red-100 border border-red-400 text-red-700';
    $:beforeMsg = isSuccess ? 'Yeah!' : 'Dammit!';

</script>

<div
    class="fixed top-2 left-2 right-2 px-4 py-3 rounded {color}"
    role="alert"
>
    <strong class="font-bold">{beforeMsg}</strong>
    <span class="block sm:inline">{message}</span>
</div>
