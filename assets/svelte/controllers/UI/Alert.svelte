<script>
    export let message;
</script>

<div
    class="fixed top-2 left-2 right-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded"
    role="alert"
>
    <strong class="font-bold">Dammit!</strong>
    <span class="block sm:inline">{message}</span>
</div>
