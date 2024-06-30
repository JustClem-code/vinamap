<script>
    export let appellationInfos;
    export let reduce;

    let appellation = appellationInfos.usedAppellation;
</script>

<div class="rounded overflow-hidden shadow-lg m-4">
    <div class="px-6 py-4">
        <div class="flex justify-between">
            <div class="mb-2">
                <span class="font-bold text-xl mb-2">{appellation.wineregionName}</span>
                &nbsp;
                <span class="text-l">{appellation?.subwineregionName}</span>
            </div>

            <div
                class="font-medium text-blue-500 underline hover:text-blue-700"
            ></div>
            <button
                on:click={() => reduce()}
                class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow"
            >
                ←
            </button>
        </div>
        <div class="font-bold text-xl mb-2">{appellation.name}</div>
        <p class="text-gray-700 text-base">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Voluptatibus quia, nulla! Maiores et perferendis eaque,
            exercitationem praesentium nihil.
        </p>
    </div>
    <div class="px-6 pt-4 pb-2">
        {#each appellation?.grapevarietyCollection as grape}
            <span
                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                >{grape.grapevarietyName}</span
            >
        {/each}
    </div>
</div>
