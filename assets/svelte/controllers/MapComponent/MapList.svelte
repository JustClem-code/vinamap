<script>
    import { spots } from "./appellations-optimised";

    export let appellationInfos;
    export let dataMap;
    export let filterItems;
    export let filterApArray;

    export let compareName;
    export let toggleRegion;
    export let toggleAppellation;

    export let zoomOnregion;

    export let enLarge;

    $: spotted = (item) => {
        let isFilterAp = filterApArray?.find(
            (f) => f.name == item.name || f.wineregionName == item.name,
        );

        if (
            compareName(appellationInfos.usedSpot?.title ?? "yo", item.name) ||
            compareName(
                appellationInfos.usedAppellation?.title ?? "yo",
                item.name,
            )
        ) {
            return isFilterAp
                ? "bg-red-300 text-red-900"
                : "bg-teal-300 text-teal-900";
        } else {
            return isFilterAp
                ? "bg-red-200 text-red-700"
                : "bg-gray-200 text-gray-700";
        }
    };

    function toggleItem(item) {
        if (dataMap.isZoomable) {
            let apOject = appellationInfos.usedSpot.appellations.find((ap) =>
                compareName(ap.title, item.name),
            );

            let subArray = appellationInfos.usedSpot.sub_wine_regions.filter(
                (d) =>
                    d.appellations.some((ap) =>
                        compareName(ap.title, item.name),
                    ),
            );

            if (subArray.length) {
                apOject = subArray[0].appellations.find((ap) =>
                    compareName(ap.title, item.name),
                );
            }

            toggleAppellation(appellationInfos.usedSpot, apOject);
        } else {
            toggleRegion(
                spots.find(
                    (spot) =>
                        spot.title.toUpperCase() === item.name.toUpperCase(),
                ),
            );
        }
    }

    function clickItem() {
        if (dataMap.isZoomable) {
            enLarge(appellationInfos.usedSpot);
        } else {
            zoomOnregion();
        }
    }
</script>

<div class="m-4">
    {#if dataMap.onLoad}
        <div class="flex flex-wrap gap-1">
            {#each Array(15) as _, i}
                <button
                    class="animate-pulse bg-gray-200 text-gray-700 inline-block rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2"
                >
                    vinamap
                </button>
            {/each}
        </div>
    {:else}
        <div class="flex flex-wrap gap-1">
            {#each filterItems as item, i}
                <button
                    on:click={() => clickItem()}
                    on:mouseenter={() => {
                        toggleItem(item);
                    }}
                    class="inline-block rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2 {spotted(
                        item,
                    )}"
                >
                    {item.name}
                </button>
            {/each}
        </div>
    {/if}
</div>
