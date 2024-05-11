<script>
    import { onMount } from "svelte";
    import MultiSelect from "svelte-multiselect";

    export let addForm;

    export let dataManagement;

    $: options = dataManagement?.options;

    let formData = {
        name: "",
        value: 0,
        value2: [],
        value3: 0,
    };

    onMount(async () => {
        const element1 = document.getElementById("first-input-create");
        element1.focus();
    });

    let item3Filter = [];
    $: if (options.items3 != null) {
        item3Filter = options.items3.filter(
            (item) => item.wineregionId === formData.value,
        );
    }

    let multiselectOptions;
    $: if (options.items2 != null) {
        multiselectOptions = options.items2.map((x) => ({
            label: x.name,
            value: x.id,
        }));
    }

    function submitForm() {
        addForm(formData);
        formData.name = "";
    }
</script>

<h2 class="text-3xl font-bold text-slate-950 mb-2">
    Créer {dataManagement.title}
</h2>

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
                bind:value={formData.name}
                id="first-input-create"
                type="text"
                placeholder={dataManagement.placeholderCreate}
                aria-label={dataManagement.title}
                required
            />
        </div>
    </div>

    {#if options.items != null}
        <div class="flex flex-wrap mb-6">
            <div class="w-full">
                <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-state"
                >
                    {options.itemsTitle}
                </label>
                <div class="relative">
                    <select
                        bind:value={formData.value}
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-state"
                    >
                        {#each options.items as item}
                            <option value={item.id}>{item.name}</option>
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
    {#if item3Filter.length > 0}
        <div class="flex flex-wrap mb-6">
            <div class="w-full">
                <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-state"
                >
                    {options.itemsTitle3}
                </label>
                <div class="relative">
                    <select
                        bind:value={formData.value3}
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-state"
                    >
                        {#each item3Filter as item}
                            <option value={item.id}
                                >{item.name}</option
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
    {#if options.items2 != null}
        <div class="flex flex-wrap mb-6">
            <div class="w-full">
                <label
                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-state"
                >
                    {options.itemsTitle2}
                </label>
                <div class="relative">
                    <MultiSelect
                        bind:value={formData.value2}
                        options={multiselectOptions}
                        placeholder={options.itemsTitle2}
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
            Créer {dataManagement.title}
        </button>
    </div>
</form>
