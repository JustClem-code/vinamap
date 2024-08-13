<script>
    import axios from "axios";
    import { onMount } from "svelte";

    export let is_user;

    import MapComponent from "./MapComponent/MapComponent.svelte";
    import MapList from "./MapComponent/MapList.svelte";
    import MapInfo from "./MapComponent/MapInfo.svelte";
    import MapFilter from "./MapComponent/MapFilter.svelte";
    import MapSearch from "./MapComponent/MapSearch.svelte";
    import MapProduct from "./MapComponent/MapProduct.svelte";

    let appellationInfos = {
        usedSpot: null,
        usedAppellation: null,
    };

    let dataMap = {
        onLoad: true,
        isZoomable: false,
        isVisible: false,
        isSearchable: false,
        defaultMatrix: "matrix(.22807, 0, 0, .22807, 1974, 984.91)",
    };

    let currentMatrix = dataMap.defaultMatrix;

    let dataManagement = {
        appellations: null,
        wineregions: null,
        grapevarietys: null,
        subwineregion: null,
        product: null,
    };

    let filterValue = [];

    let filterApArray = [];

    let filterItems = null;

    onMount(async () => {
        await Promise.all([
            getAppellation(),
            getWineregion(),
            getGrapeVariety(),
            getSubwineregion(),
            getProduct(),
        ]);
        dataMap.onLoad = false;
    });

    $: filterProducts = dataManagement.product?.filter(
        (p) => p.appellationName == appellationInfos.usedAppellation?.name,
    );

    $: if (filterValue.length) {
        grapeFilter(dataManagement.appellations);
    } else {
        filterApArray = [];
    }

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

    // GET

    async function getAppellation() {
        const response = await axios.get(`/getappellations`);
        dataManagement.appellations = response.data;
    }
    async function getWineregion() {
        const response = await axios.get(`/getwineregions`);
        dataManagement.wineregions = response.data;
    }
    async function getGrapeVariety() {
        const response = await axios.get(`/getgrapevarietys`);
        dataManagement.grapevarietys = response.data;
    }
    async function getSubwineregion() {
        const response = await axios.get(`/getsubwineregions`);
        dataManagement.subwineregion = response.data;
    }
    async function getProduct() {
        if (!is_user) {
            return;
        }
        const response = await axios.get(`/getproducts`);
        dataManagement.product = response.data;
    }

    // METHODS

    function compareName(title, name) {
        return (
            title.localeCompare(name, undefined, {
                sensitivity: "accent",
            }) === 0
        );
    }

    function grapeFilter(ar) {
        filterApArray = ar.filter(({ grapevarietyCollection }) => {
            return grapevarietyCollection.some(({ grapevarietyId }) => {
                return filterValue.some((f) => {
                    return f.value === grapevarietyId;
                });
            });
        });
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

        dataManagement.appellations.find((element) => {
            if (compareName(appellation?.title, element.name)) {
                mergedAp = { ...element, ...appellation };
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
        if (!dataMap.isZoomable) {
            return;
        }
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
        if (!dataMap.isVisible) {
            return;
        }
        dataMap.isVisible = false;
        dataMap.isSearchable = false;
    }
</script>

<div class="flex flex-col md:flex-row md:justify-around p-1 md:p-10">
    <MapComponent
        bind:appellationInfos
        bind:dataMap
        bind:currentMatrix
        bind:filterApArray
        {dataManagement}
        {compareName}
        {toggleRegion}
        {toggleAppellation}
        {zoomOnregion}
        {backZoom}
        {enLarge}
        {reduce}
    ></MapComponent>
    <div class="w-full md:w-6/12">
        <MapSearch
            bind:appellationInfos
            bind:dataMap
            {dataManagement}
            {compareName}
            {toggleRegion}
            {toggleAppellation}
            {zoomOnregion}
            {backZoom}
            {enLarge}
            {reduce}
        ></MapSearch>
        <MapFilter {dataManagement} bind:filterValue></MapFilter>
        {#if dataMap.isVisible}
            <MapInfo {appellationInfos} {reduce} {filterValue}></MapInfo>
            {#if is_user && filterProducts.length}
                <MapProduct {filterProducts} />
            {/if}
        {:else}
            <MapList
                bind:appellationInfos
                bind:dataMap
                bind:filterItems
                bind:filterApArray
                {dataManagement}
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
