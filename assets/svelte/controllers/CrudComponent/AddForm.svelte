<script>
    import { onMount } from "svelte";
    import MultiSelect from "svelte-multiselect";

    export let addForm;
    export let titleForm;
    export let placeholder;

    export let optionItemsTitle;
    export let optionItems;
    export let optionItemsTitle2;
    export let optionItems2;
    export let optionItemsTitle3;
    export let optionItems3;

    let name = "";
    let optionValue = 0;
    let optionValue2 = [];
    let optionValue3 = 0;

    onMount(async () => {
        const element1 = document.getElementById("first-input-create");
        element1.focus();
    });

    let optionItem3Filter = [];
    $: if (optionItems3 != null) {
        optionItem3Filter = optionItems3.filter((item) => item.wineregionId === optionValue)
    }

    let multiselectOptions;
    $: if (optionItems2 != null) {
        multiselectOptions = optionItems2.map((x) => ({
            label: x.name,
            value: x.id,
        }));
    }

    function submitForm() {
        addForm(name, optionValue, optionValue2, optionValue3);
        name = "";
    }
</script>

<h2 class="text-3xl font-bold text-slate-950 mb-2">Créer {titleForm}</h2>

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
            <div class="w-full">
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
    {#if optionItem3Filter.length > 0}
        <div class="flex flex-wrap mb-6">
            <div class="w-full">
                <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-state"
                >
                    {optionItemsTitle3}
                </label>
                <div class="relative">
                    <select
                        bind:value={optionValue3}
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-state"
                    >
                        {#each optionItem3Filter as optonItem}
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
    {#if optionItems2 != null}
        <div class="flex flex-wrap mb-6">
            <div class="w-full">
                <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-state"
                >
                    {optionItemsTitle2}
                </label>
                <div class="relative">
                    <MultiSelect
                        bind:value={optionValue2}
                        options={multiselectOptions}
                        placeholder={optionItemsTitle2}
                    />
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
