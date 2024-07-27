<script>
    import { spots } from "./appellations-optimised";
    import MultiSelect from "svelte-multiselect";

    export let appellationInfos;
    export let dataManagement;
    export let dataMap;

    export let compareName;
    export let toggleRegion;
    export let toggleAppellation;
    export let zoomOnregion;
    export let backZoom;
    export let enLarge;
    export let reduce;

    let multiselectOptions;
    $: if (dataManagement.appellations != null) {
        multiselectOptions = dataManagement.appellations
            .map((x) => ({
                label: x.name,
                name: x.name,
                value: x.wineregionName,
            }))
            .sort((a, b) =>
                a.name.toLowerCase().localeCompare(b.name.toLowerCase()),
            );
    }

    function search(item) {
        dataMap.isSearchable = true;

        toggleRegion(spots.find((spot) => compareName(spot.title, item.value)));
        zoomOnregion();
        toggleItem(item);
        setTimeout(() => {
            enLarge(appellationInfos.usedSpot);
        }, 300);
    }

    function unSearch(e) {
        reduce();
        backZoom();
    }

    function toggleItem(item) {
        let apOject = appellationInfos.usedSpot.appellations.find((ap) =>
            compareName(ap.title, item.name),
        );

        let subArray = appellationInfos.usedSpot.sub_wine_regions.filter((d) =>
            d.appellations.some((ap) => compareName(ap.title, item.name)),
        );

        if (subArray.length) {
            apOject = subArray[0].appellations.find((ap) =>
                compareName(ap.title, item.name),
            );
        }

        toggleAppellation(appellationInfos.usedSpot, apOject);
    }
</script>

{#if dataManagement.appellations != null}
    <div class="flex flex-wrap m-4">
        <div class="w-full">
            <label
                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                for="grid-state"
            >
                Rechercher une appellation
            </label>
            <div class="relative">
                <MultiSelect
                    on:add={(event) => search(event.detail.option)}
                    on:remove={(event) => unSearch(event.detail.option)}
                    options={multiselectOptions}
                    placeholder="Appellation"
                    maxSelect="1"
                    showOptions={true}
                    closeDropdownOnSelect={true}
                    disabled={(dataMap.isZoomable || dataMap.isVisible) &&
                        !dataMap.isSearchable}
                />
            </div>
        </div>
    </div>
{/if}
