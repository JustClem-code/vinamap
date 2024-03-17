<script>
    import { onMount } from "svelte";

    export let addForm;
    export let titleForm;
    export let placeholder;

    let name = "";

    onMount(() => {
        const element1 = document.getElementById("first-input-create");
        element1.focus();
    });

    function submitForm() {
        addForm(name);
        name = "";
    }
</script>

<h2 class="text-3xl font-bold text-slate-950">Créer {titleForm}</h2>

<form on:submit|preventDefault={submitForm} class="w-full max-w-sm">
    <div class="flex items-center border-b border-teal-500 py-2">
        <input
            bind:value={name}
            id="first-input-create"
            class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
            type="text"
            placeholder={placeholder}
            aria-label={titleForm}
            required
        />
        <button
            class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
            type="submit"
        >
            Créer {titleForm}
        </button>
    </div>
</form>
