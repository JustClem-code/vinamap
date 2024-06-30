<script>
    import axios from "axios";
    import { onMount } from "svelte";

    import MapComponent from "./MapComponent/MapComponent.svelte";
    import MapList from "./MapComponent/MapList.svelte";
    import MapInfo from "./MapComponent/MapInfo.svelte";

    let appellationInfos = {
        usedSpot: null,
        usedAppellation: null,
    };

    let dataMap = {
        onLoad: true,
        isZoomable: false,
        isVisible: false,
        defaultMatrix: "matrix(.22807, 0, 0, .22807, 1974, 984.91)",
    };

    let currentMatrix = dataMap.defaultMatrix;

    let dataManagement = {
        appellations: null,
        wineregions: null,
        grapevarietys: null,
        subwineregion: null,
    };

    let filterItems = null;

    onMount(async () => {
        await Promise.all([
            getAppellation(),
            getWineregion(),
            getGrapeVariety(),
            getSubwineregion(),
        ]);
        dataMap.onLoad = false;
    });

    $: console.log("debug", appellationInfos.usedAppellation);

    $: if (dataMap.isZoomable) {
        filterItems = dataManagement.appellations
            .filter((item) => {
                return item.wineregionName == appellationInfos.usedSpot.title;
            })
            .sort((a, b) =>
                a.name.toLowerCase().localeCompare(b.name.toLowerCase()),
            );
    } else {
        filterItems = dataManagement.wineregions?.sort((a, b) =>
            a.name.toLowerCase().localeCompare(b.name.toLowerCase()),
        );
    }

    async function getAppellation() {
        const response = await axios.get(`https://localhost/getappellations`);
        dataManagement.appellations = response.data;
    }
    async function getWineregion() {
        const response = await axios.get(`https://localhost/getwineregions`);
        dataManagement.wineregions = response.data;
    }
    async function getGrapeVariety() {
        const response = await axios.get(`https://localhost/getgrapevarietys`);
        dataManagement.grapevarietys = response.data;
    }
    async function getSubwineregion() {
        const response = await axios.get(`https://localhost/getsubwineregions`);
        dataManagement.subwineregion = response.data;
    }

    function compareName(title, name) {
        return (
            title.localeCompare(name, undefined, {
                sensitivity: "accent",
            }) === 0
        );
    }

    function toggleRegion(spot) {
        if (dataMap.isZoomable) {
            return;
        }
        appellationInfos.usedSpot = spot;
    }

    function toggleAppellation(spot, appellation) {
        if (
            !dataMap.isZoomable ||
            dataMap.isVisible ||
            spot != appellationInfos.usedSpot
        ) {
            return;
        }

        let mergedAp;

        dataManagement.appellations.find(element => {
            if (compareName(appellation?.title, element.name)) {
                mergedAp = {...element, ...appellation};
            }
        });

        appellationInfos.usedAppellation = mergedAp;
    }

    function zoomAnimation(matrix_begin, matrix_end) {
        const newspaperSpinning = [
            { transform: matrix_begin },
            { transform: matrix_end },
        ];

        const newspaperTiming = {
            duration: 200,
            iterations: 1,
        };

        const newspaper = document.querySelector("#g1424");

        newspaper.animate(newspaperSpinning, newspaperTiming);

        currentMatrix = matrix_end;
    }

    function zoomOnregion() {
        if (dataMap.isZoomable) {
            return;
        }

        zoomAnimation(currentMatrix, appellationInfos.usedSpot.transform_zoom);

        dataMap.isZoomable = true;
    }

    function backZoom() {
        zoomAnimation(currentMatrix, dataMap.defaultMatrix);

        dataMap.isZoomable = false;
    }

    function enLarge(spot) {
        if (!dataMap.isZoomable || spot != appellationInfos.usedSpot) {
            return;
        }
        dataMap.isVisible = true;
    }

    function reduce() {
        dataMap.isVisible = false;
    }
</script>

<div class="flex flex-col md:flex-row md:justify-around p-1 md:p-10">
    <MapComponent
        bind:appellationInfos
        bind:dataMap
        bind:currentMatrix
        {toggleRegion}
        {toggleAppellation}
        {zoomOnregion}
        {backZoom}
        {enLarge}
        {reduce}
    ></MapComponent>
    <div class="w-full md:w-6/12">
        {#if dataMap.isVisible}
            <MapInfo {appellationInfos} {reduce}></MapInfo>
        {:else}
            <MapList
                bind:appellationInfos
                bind:dataMap
                bind:filterItems
                {compareName}
                {toggleRegion}
                {toggleAppellation}
                {zoomOnregion}
                {enLarge}
                {reduce}
            ></MapList>
        {/if}
    </div>
</div>
