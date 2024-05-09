<script>
    import { spots } from "./spots";

    export let usedSpot = null;

    let newSpots = spots;

    function toggleSpot(spot) {
        usedSpot = spot;
    }

    $: active_class = usedSpot ? "less_opacity" : "";
</script>

<!-- 0 0 613 585 -->
<div class="w-6/12 m-4">
    <svg
        xmlns="http://www.w3.org/2000/svg"
        xmlns:amcharts="http://amcharts.com/ammap"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        version="1.1"
        viewBox="-50 -50 713 685"
        height="100%"
        width="100%"
        role="figure"
        on:mouseleave={() => {
            toggleSpot(null);
        }}
    >
        <defs>
            <filter id="blur">
                <feGaussianBlur stdDeviation="1" />
            </filter>
        </defs>
        {#each newSpots as spot, index}
            <path
                role="figure"
                id={spot.id}
                title={spot.title}
                d={spot.d}
                class="land grow {active_class}"
                on:mouseenter={() => {
                    toggleSpot(spot);
                }}
            ></path>
        {/each}
        {#if usedSpot}
            <path
                role="figure"
                id={usedSpot.id}
                title={usedSpot.title}
                d={usedSpot.d}
                class="land hover_grow"
                on:mouseleave={() => {
                    toggleSpot(null);
                }}
            ></path>
        {/if}
    </svg>
</div>

<style>
    .less_opacity {
        fill-opacity: 0.8;
        stroke-opacity: 0.8;
        filter: url(#blur);
    }

    .grow {
        fill: #115e59;
        stroke: #14b8a6;
        stroke-width: 2px;
        transform: scale(1);
        transform-origin: 50% 50%;
        transition: 0.3s;
        transform-box: fill-box;
    }

    .hover_grow {
        fill: #14b8a6 !important;
        stroke: #042f2e;
        stroke-width: 1px;
        transform: scale(1);
        transform-origin: 50% 50%;
        transition: 0.6s;
        transform-box: fill-box;
    }

    .hover_grow:hover {
        transform: scale(1.5);
        transform-origin: 50% 50%;
        transition: 0.6s;
    }
</style>
