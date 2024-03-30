<script>
    import { onMount } from "svelte";

    export let addForm;
    export let titleForm;
    export let placeholder;
    export let optionItemsTitle;
    export let optionItems;

    let name = "";
    let optionValue = 0;

    onMount(() => {
        const element1 = document.getElementById("first-input-create");
        element1.focus();
    });

    function submitForm() {
        console.log(optionValue);
        addForm(name, optionValue);
        name = "";
    }
</script>

<h2 class="text-3xl font-bold text-slate-950 mb-2">Créer {titleForm}</h2>

<!-- <form on:submit|preventDefault={submitForm} class="w-full max-w-sm">
    <div class="flex items-center border-b border-teal-500 py-2">
        <input
            class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
            bind:value={name}
            id="first-input-create"
            type="text"
            {placeholder}
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
</form> -->

<form on:submit|preventDefault={submitForm} class="w-full max-w-lg">
    <div class="flex flex-wrap mb-6">
        <div class="w-full">
            <label
                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                for="grid-password"
            >
                Nom
            </label>
            <input
                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                bind:value={name}
                id="first-input-create"
                type="text"
                {placeholder}
                aria-label={titleForm}
                required
            />
        </div>
    </div>

    {#if optionItems != null}
        <div class="flex flex-wrap mb-6">
            <div class="w-full md:w-1/3 mb-6 md:mb-0">
                <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-state"
                >
                    {optionItemsTitle}
                </label>
                <div class="relative">
                    <select
                        bind:value={optionValue}
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-state"
                    >
                        {#each optionItems as optonItem}
                            <option value={optonItem.id}
                                >{optonItem.name}</option
                            >
                        {/each}
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                    >
                        <svg
                            class="fill-current h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            ><path
                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                            /></svg
                        >
                    </div>
                </div>
            </div>
        </div>
    {/if}

    <div>
        <button
            class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 border-4 text-white py-1 px-2 rounded"
            type="submit"
        >
            Créer {titleForm}
        </button>
    </div>
</form>
