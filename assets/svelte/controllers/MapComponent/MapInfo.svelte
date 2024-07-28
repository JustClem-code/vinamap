<script>
    import { onMount } from "svelte";

    export let appellationInfos;
    export let reduce;
    export let filterValue;

    let appellation = appellationInfos.usedAppellation;

    let nameSearch = appellation.name.toLowerCase();

    let loadWiki = false;

    onMount(async () => {
        await getWikiText();
        loadWiki = true;
    });
    
    $: wiki = "";

    $: isGrape = (grapeName) => {
        let result = filterValue.find((grape) => grape.label == grapeName);
        return result ? "bg-red-200 text-red-700" : "bg-gray-200 text-gray-700";
    };


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

        if (wiki[0]?.includes("\x3C!--") || wiki[0] == null) {
            response = await fetch(
                `https://fr.wikipedia.org/w/api.php?action=query&origin=*&prop=extracts&format=json&exintro=&titles=${nameSearch}`,
            );
            let jsonContent = await response.json();

            wiki = extractAPIContents(jsonContent);
            if (
                wiki[0]?.includes("\x3C!--") ||
                wiki[0] == "" ||
                !wiki[0]?.includes("vin")
            ) {
                wiki[0] = null;
            }
        } else if (wiki[0] == "") {
            wiki[0] = null;
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
        {#if loadWiki}
            {#if wiki[0] != null}
                <p class="text-gray-700 text-base mb-1">{@html wiki}</p>
                <p>Source : Wikipedia</p>
            {:else}
                <p class="text-gray-700 text-base">
                    Pas de description de Wikipedia pour le moment :/
                </p>
            {/if}
        {:else}
            <div class="pl-4 flex items-center wrap gap-1">
                <div
                    class="animate-pulse h-2 w-2 bg-slate-400 rounded-full"
                ></div>
                <div
                    class="animate-pulse h-4 w-20 bg-slate-400 rounded-full"
                ></div>
                <div
                    class="animate-pulse h-4 w-10 bg-slate-400 rounded-full"
                ></div>
                <div
                    class="animate-pulse h-4 w-4 bg-slate-400 rounded-full"
                ></div>
            </div>
        {/if}
    </div>
    <div class="px-6 pt-4 pb-2">
        {#each appellation?.grapevarietyCollection as grape}
            <span
                class="inline-block rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2 {isGrape(
                    grape.grapevarietyName,
                )}">{grape.grapevarietyName}</span
            >
        {/each}
    </div>
</div>
