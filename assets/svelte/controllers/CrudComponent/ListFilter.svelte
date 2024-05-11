<script>
    import MultiSelect from "svelte-multiselect";

    export let dataOptions;

    $: console.log("dataOptions", dataOptions);

    export let filterValue;
    export let filterValue2;
    export let filterValue3;

    let multiselectOptions;
    $: if (dataOptions.items != null) {
        multiselectOptions = dataOptions.items.map((x) => ({
            label: x.name,
            value: x.id,
        }));
    }
    let multiselectOptions2;
    $: if (dataOptions.items2 != null) {
        multiselectOptions2 = dataOptions.items2.map((x) => ({
            label: x.name,
            value: x.id,
        }));
    }
    let multiselectOptions3;
    $: if (dataOptions.items3 != null) {
        multiselectOptions3 = dataOptions.items3.map((x) => ({
            label: x.name,
            value: x.id,
        }));
    }
</script>

<h2 class="text-3xl font-bold text-slate-950 mb-2">Filtrer</h2>

{#if dataOptions.items != null}
    <div class="flex flex-wrap mb-6">
        <div class="w-full">
            <label
                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                for="grid-state"
            >
                {dataOptions.itemsTitle}
            </label>
            <div class="relative">
                <MultiSelect
                    bind:value={filterValue}
                    options={multiselectOptions}
                    placeholder={dataOptions.itemsTitle}
                />
            </div>
        </div>
    </div>
{/if}
{#if dataOptions.items2 != null}
    <div class="flex flex-wrap mb-6">
        <div class="w-full">
            <label
                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                for="grid-state"
            >
                {dataOptions.itemsTitle2}
            </label>
            <div class="relative">
                <MultiSelect
                    bind:value={filterValue2}
                    options={multiselectOptions2}
                    placeholder={dataOptions.itemsTitle2}
                />
            </div>
        </div>
    </div>
{/if}
{#if dataOptions.items3 != null}
    <div class="flex flex-wrap mb-6">
        <div class="w-full">
            <label
                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                for="grid-state"
            >
                {dataOptions.itemsTitle3}
            </label>
            <div class="relative">
                <MultiSelect
                    bind:value={filterValue3}
                    options={multiselectOptions3}
                    placeholder={dataOptions.itemsTitle3}
                />
            </div>
        </div>
    </div>
{/if}
