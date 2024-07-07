<script>
    import MultiSelect from "svelte-multiselect";

    export let dataManagement;

    export let filterValue;

    let multiselectOptions;
    $: if (dataManagement.grapevarietys != null) {
        multiselectOptions = dataManagement.grapevarietys.map((x) => ({
            label: x.name,
            value: x.id,
        }));
    }


</script>

{#if dataManagement.grapevarietys != null}
    <div class="flex flex-wrap m-4">
        <div class="w-full">
            <label
                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                for="grid-state"
            >
                Filtrer par cépage
            </label>
            <div class="relative">
                <MultiSelect
                    bind:value={filterValue}
                    options={multiselectOptions}
                    placeholder="Cépages"
                />
            </div>
        </div>
    </div>
{/if}
