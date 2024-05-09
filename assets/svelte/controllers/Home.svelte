<script>
    import MapComponent from "./MapComponent/MapComponent.svelte";
    import MapInfo from "./MapComponent/MapInfo.svelte";

    let usedSpot = null;

</script>

<div class="flex justify-around">
    <MapComponent bind:usedSpot></MapComponent>
    <MapInfo {usedSpot}></MapInfo>
</div>
