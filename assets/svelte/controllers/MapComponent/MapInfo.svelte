<script>
    import axios from "axios";
    import { onMount } from "svelte";

    export let appellationInfos;
    export let reduce;

    let appellation = appellationInfos.usedAppellation;

    let nameSearch = appellation.name.toLowerCase();

    onMount(async () => {
        await getWikiText();
    });

    $: wiki = "";

    async function getWikiText() {
        let response = await fetch(
            `https://fr.wikipedia.org/w/api.php?action=query&origin=*&prop=extracts&format=json&exintro=&titles=${nameSearch}_(AOC)`,
        );

        const extractAPIContents = (json) => {
            const { pages } = json.query;
            return Object.keys(pages).map((id) => pages[id].extract);
        };
        let jsonContent = await response.json();

        wiki = extractAPIContents(jsonContent);

        if ((wiki[0]?.includes("\x3C!--") || (wiki[0] == null))) {
            response = await fetch(
                `https://fr.wikipedia.org/w/api.php?action=query&origin=*&prop=extracts&format=json&exintro=&titles=${nameSearch}`,
            );
            let jsonContent = await response.json();

            wiki = extractAPIContents(jsonContent);
            if ((wiki[0]?.includes("\x3C!--")) || (wiki[0] == '') || (!wiki[0]?.includes("vin"))) {
                wiki[0] = null
            }

        } else if (wiki[0] == '') {
            wiki[0] = null
        }
    }
</script>

<div class="rounded overflow-hidden shadow-lg m-4">
    <div class="px-6 py-4">
        <div class="flex justify-between">
            <div class="mb-2">
                <span class="font-bold text-xl mb-2"
                    >{appellation.wineregionName}</span
                >
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
        {#if wiki[0] != null}
            <p class="text-gray-700 text-base mb-1">{@html wiki}</p>
            <p>Source : Wikipedia</p>
        {:else}
            <p class="text-gray-700 text-base">
                Pas de description de Wikipedia pour le moment :/
            </p>
        {/if}
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
