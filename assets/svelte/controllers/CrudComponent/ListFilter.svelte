<script>
    import { onMount } from "svelte";
    import MultiSelect from "svelte-multiselect";

    export let optionItemsTitle;
    export let optionItems;
    export let optionItemsTitle2;
    export let optionItems2;
    export let optionItemsTitle3;
    export let optionItems3;

    export let filterValue;
    export let filterValue2;
    export let filterValue3;

    $: console.log("filter", filterValue);
    $: console.log("filter", filterValue2);

    onMount(async () => {
        const element1 = document.getElementById("first-input-create");
        element1.focus();
    });

    let multiselectOptions;
    $: if (optionItems != null) {
        multiselectOptions = optionItems.map((x) => ({
            label: x.name,
            value: x.id,
        }));
    }
    let multiselectOptions2;
    $: if (optionItems2 != null) {
        multiselectOptions2 = optionItems2.map((x) => ({
            label: x.name,
            value: x.id,
        }));
    }
    let multiselectOptions3;
    $: if (optionItems3 != null) {
        multiselectOptions3 = optionItems3.map((x) => ({
            label: x.name,
            value: x.id,
        }));
    }

</script>

<h2 class="text-3xl font-bold text-slate-950 mb-2">Filtrer</h2>

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
                <MultiSelect
                    bind:value={filterValue}
                    options={multiselectOptions}
                    placeholder={optionItemsTitle}
                />
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
                    bind:value={filterValue2}
                    options={multiselectOptions2}
                    placeholder={optionItemsTitle2}
                />
            </div>
        </div>
    </div>
{/if}
{#if optionItems3 != null}
    <div class="flex flex-wrap mb-6">
        <div class="w-full">
            <label
                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                for="grid-state"
            >
                {optionItemsTitle3}
            </label>
            <div class="relative">
                <MultiSelect
                    bind:value={filterValue3}
                    options={multiselectOptions3}
                    placeholder={optionItemsTitle3}
                />
            </div>
        </div>
    </div>
{/if}
