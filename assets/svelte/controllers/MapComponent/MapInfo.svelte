<script>
    export let appellationInfos;

    let region = {
        'title': 'Region',
        'id': 'FR',
    }
    let appellation = {
        'title': 'Appellation',
        'id': 'FR',
    }

    let defautRegion = region;
    let defautApellation = appellation;

    $: if (appellationInfos.usedSpot && appellationInfos.usedAppellation) {
        defautRegion = appellationInfos.usedSpot;
        defautApellation = appellationInfos.usedAppellation
    } else {
        defautRegion = region;
        defautApellation = appellation;
    }

</script>

<div class="max-w-sm rounded overflow-hidden shadow-lg m-4">

        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2">{defautRegion.title}</div>
            <div class="font-bold text-xl mb-2">{defautApellation.title}</div>
            <p class="text-gray-700 text-base">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Voluptatibus quia, nulla! Maiores et perferendis eaque,
                exercitationem praesentium nihil.
            </p>
        </div>
        <div class="px-6 pt-4 pb-2">
            <span
                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                >#{defautRegion.id}</span
            >
            <span
                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                >#travel</span
            >
            <span
                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                >#winter</span
            >
        </div>

</div>
