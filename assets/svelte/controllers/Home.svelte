<script>
    import MapComponent from "./MapComponent/MapComponent.svelte";
    import MapInfo from "./MapComponent/MapInfo.svelte";

    let appellationInfos = {
        usedSpot: null,
        usedAppellation: null,
    }

</script>

<div class="flex justify-around">
    <MapComponent bind:appellationInfos></MapComponent>
    <MapInfo {appellationInfos}></MapInfo>
</div>
