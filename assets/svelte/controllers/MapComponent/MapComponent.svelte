<script>
    import { spots } from "./appellations-optimised";

    import { fade } from "svelte/transition";

    export let appellationInfos;
    export let dataMap;
    export let currentMatrix;
    export let filterApArray;
    export let dataManagement;

    export let compareName;
    export let toggleRegion;
    export let toggleAppellation;
    export let zoomOnregion;
    export let backZoom;
    export let enLarge;
    export let reduce;

    let newSpots = spots;

    $: isFiteredEnlarge = filterApArray?.some((item) =>
        compareName(item.name, appellationInfos.usedAppellation?.title),
    );

    $: spotted = (spot, appellationTitle) => {
        let isFilterAp = filterApArray?.some((item) =>
            compareName(appellationTitle, item.name),
        );

        let isProduct = dataManagement.product?.find((item) =>
            compareName(appellationTitle, item.appellationName),
        );

        let isUsedAp =
            appellationTitle == appellationInfos.usedAppellation?.title;

        // REGION
        if (spot == appellationInfos.usedSpot) {
            //ZOOM sur la region
            if (dataMap.isZoomable) {
                if (isFilterAp) {
                    if (isUsedAp) {
                        return isProduct ? "product_spotted_filtered_color" : "spotted_filtered_color";
                    } else {
                        return isProduct ? "product_filtered_color" : "filtered_color";
                    }
                } else {
                    if (isUsedAp) {
                        return isProduct ? "product_spotted_color" : "spotted_color";
                    } else {
                        return isProduct ? "product_grow" : "grow";
                    }
                }
            } else {
                if (isFilterAp) {
                    return isProduct ? "product_spotted_filtered_color" : "spotted_filtered_color";
                } else {
                    return isProduct ? "product_grow" : "spotted_color";
                }
            }
        } else {
            if (dataMap.isZoomable) {
                return "grow_inactive";
            } else {
                if (isFilterAp) {
                    return isProduct
                        ? "product_filtered_color"
                        : "filtered_color";
                } else {
                    return isProduct ? "product_grow" : "grow";
                }
            }
        }
    };
</script>

<div
    class="md:w-6/12 aspect-square m-4 relative rounded shadow-lg h-max overflow-hidden"
    in:fade
>
    {#if dataMap.isZoomable && !dataMap.isVisible}
        <button
            on:click={() => backZoom()}
            class="absolute top-4 right-4 flex-shrink-0 bg-teal-900 text-teal-300 border-teal-300 hover:bg-teal-300 hover:text-teal-900 hover:border-teal-900 border-4 py-1 px-2 rounded"
            >Retour</button
        >
    {/if}
    <svg
        width="100%"
        version="1.1"
        viewBox="0 0 2e3 2e3"
        xmlns="http://www.w3.org/2000/svg"
    >
        <!--  <rect
            id="rect1524"
            x=".42568"
            y=".4257"
            width="1999.1"
            height="1999.1"
            fill="#fff"
        /> -->
        <g id="g1424" transform={currentMatrix}>
            <g
                id="g9344"
                transform="matrix(.59034 0 0 -.59034 -7853 3751.4)"
                fill="#0d9488"
                stroke="var(--color-teal-950)"
                stroke-width="37.5"
            >
                <path
                    id="path9340"
                    d="m6145 11934c-60-51-88-64-143-64-34 0-75-9-115-26-84-35-152-53-167-44-27 17-169-41-210-85-14-15-49-45-77-66-30-22-55-50-59-64-3-14-1-55 6-93 7-37 18-101 26-142 17-96 18-186 3-280-19-116-16-142 19-208l31-61-41 2c-44 2-42 3-79-77-13-29-51-78-91-117-56-56-78-70-125-84-32-9-102-38-155-66-124-62-233-99-296-99-44 0-58-6-124-54-72-53-219-126-253-126-9 0-29-12-44-28-23-23-29-39-34-99-4-39-12-84-17-99-13-33-16-91-6-101 4-5 32-10 62-13l55-5-82-50c-209-128-213-129-315-96-33 10-119 24-191 30-85 7-153 18-190 32-128 46-164 47-231 8-41-24-42-24-42 3 0 22-55 112-99 160l-24 27 38 35c37 35 38 36 32 93-7 70-29 93-108 112-53 13-55 12-129-23-41-20-82-36-92-36s-30 14-45 31c-42 47-83 62-138 48-24-6-52-9-60-5-25 9-65-11-65-34 0-11 20-40 44-65 63-63 66-69 50-134-20-84-18-109 15-146 23-26 30-46 36-99 6-64 8-67 51-97 69-47 72-55 80-234 7-157 7-159 35-185 28-25 28-25 17-91-16-94 4-200 43-234l28-23-47-6c-26-3-60-6-77-6-16 1-44-7-61-16-22-12-42-15-67-10-37 7-37 8-37 55 0 55-9 66-67 79-57 13-87-3-91-48-4-39-11-46-67-61-22-6-49-17-61-24-20-13-21-12-20 22 1 46-22 63-58 43-23-12-28-11-39 5-12 15-22 17-62 10-42-6-57-15-106-65-31-32-65-72-75-89s-21-31-25-31c-3 0-12 26-19 57-10 46-21 66-59 104-28 28-59 75-80 120-60 132-53 124-94 125-32 0-41 6-57 32-20 32-61 44-75 22-3-5-21-10-38-10-38 0-90-29-113-65-21-32-78-36-94-5-18 33-48 44-74 26-20-13-24-25-28-89-3-40-8-79-12-85-5-8-38-12-90-12-72 0-86-3-116-25-43-32-76-33-86-2-16 53-59 71-107 45-12-6-47-30-77-53-55-43-56-43-79-24-13 11-31 19-41 19-16 0-233-106-287-140-21-13-123-202-123-228 0-36 125-65 176-39 16 8 50 17 76 20 56 8 74-7 59-46-8-20-18-26-47-29-34-3-38-6-50-48-10-33-10-47-2-58 19-23 65-42 101-42 26 0 45-10 77-37l42-38-112-1c-95-1-116-4-138-21-20-15-27-29-27-54 0-33 2-35 60-54 69-23 81-30 114-67 22-25 23-30 12-73-13-53 3-106 40-125 32-18 141-7 182 17 18 11 62 23 97 27 37 4 73 15 84 24 15 14 20 14 24 4 8-23 64-82 91-96 14-8 53-17 86-21 74-9 111-27 118-57 10-38 81-101 114-99 124 5 131 4 171-39 36-37 43-40 93-40 30 0 69 4 87 9 25 8 32 7 32-5 0-8 16-32 36-53l35-40 133 6c119 5 133 4 139-11 4-10 0-31-9-47-24-48-30-158-10-197 28-54 49-62 146-53 47 4 93 11 104 16 16 7 18 5 14-21-3-16-11-42-18-59-9-23-10-40-1-71 10-36 16-43 45-48 38-7 53-21 56-51 4-35 1-43-19-50-10-3-31-17-45-30-33-31-34-71-1-150 19-48 33-66 70-90 36-24 57-49 96-120 27-49 54-108 59-130 10-47 60-96 153-150 34-20 83-50 109-67 28-18 66-32 92-35 38-5 46-10 57-35 28-67 61-73 151-28l60 31-6-27c-4-15-16-40-27-55-24-34-24-55 0-110 30-70 46-156 32-172-6-8-10-39-9-70s-1-59-5-63c-12-13-39 22-56 72-11 31-29 58-53 77-36 29-38 29-63 13-34-23-32-57 10-138 18-37 37-83 41-103 5-29 10-35 32-35h25l-21-23c-26-28-27-45-4-73s46-39 108-53c41-10 61-23 106-69 68-71 109-124 137-179 22-43 56-172 47-180-2-2-7 11-11 29s-17 51-30 73c-25 44-157 172-228 222-76 53-82 37-98-252-5-93-14-235-20-315-7-80-11-176-11-213 1-51-4-79-19-109-39-77-8-108 69-69 45 23 52 20 52-21 0-22-4-28-22-28-13 0-41-11-63-23-38-21-40-26-47-82-4-33-14-91-22-130-8-38-20-142-26-230-12-182-47-371-118-629-63-230-119-323-212-350-44-13-45-15-43-51 4-55 18-67 68-59 42 6 43 5 54-29 7-20 17-38 24-40 20-7 47 12 47 33 0 11 1 20 3 20 1 0 32-10 68-23 61-22 65-25 58-48-10-39-30-72-61-101-15-14-28-31-28-37 0-17 67-81 85-81 9 0 29 10 45 21l29 22 39-32c29-22 50-31 78-31 25 0 45-7 60-21 13-13 39-23 61-25 21-1 58-10 82-18 24-9 58-16 76-16 23 0 43-10 74-40 23-23 52-40 65-40 32 0 53-20 63-60 11-44 39-50 79-17 22 19 37 23 66 19 27-3 45 2 67 17l30 21 53-56c29-31 55-59 58-63s18-17 34-29c40-30 105-29 175 3l55 26 41-41c22-22 45-40 51-40s21 11 33 24c20 21 27 23 63 14 23-5 77-7 120-5 70 3 82 7 108 32 32 31 39 71 20 121-6 15-9 28-7 30s39-11 83-30c48-20 104-35 144-39 86-8 92-11 112-57 13-32 22-40 43-40 15 0 33 7 41 15 14 13 20 12 55-5 21-11 39-27 39-34 0-8 12-28 26-45 33-40 74-42 103-5 18 23 23 25 38 13 9-8 36-14 60-14 43 0 45-1 59-40 11-32 12-45 2-63-16-31 0-55 38-56 16-1 53-16 82-35 42-27 52-38 52-61 0-48 22-56 93-35 34 10 86 29 115 43l54 24 60-31c47-24 74-31 116-31 47 0 60-4 84-27l28-27 28 22c54 43 134 84 206 107s77 23 146 9c112-24 127-5 61 74-68 82-84 163-55 276 16 63 15 162-4 276-9 54-9 56 27 96 35 40 53 70 64 105 4 11 22 18 57 22 29 4 60 13 70 22 9 8 32 15 50 15 28 0 44 11 97 65 48 50 63 72 63 94 0 32 33 52 53 32 18-18 62-12 85 12 12 12 32 42 45 67 16 30 32 46 51 51 16 4 36 15 46 24 16 15 18 13 30-15 8-18 28-39 49-50 20-10 49-32 65-49 32-34 82-42 92-16 5 12 10 10 26-11 40-50 101-50 140-1l18 22v-27c0-35 28-51 61-34 21 11 29 8 70-21 111-79 175-77 201 8 6 22 14 39 18 39 10 0 40-35 40-47 0-29 39-43 151-53 62-5 122-10 132-10 23 0 22-22-4-71-23-47-22-92 3-97 10-2 47 8 83 23 75 30 97 27 122-17 10-16 39-41 64-53 52-27 170-51 197-40 26 11 317 37 395 35 51-1 75 3 95 17 14 10 49 29 77 43 27 14 50 30 51 35 0 6 4 33 8 60 6 42 12 53 37 68 18 10 37 33 46 57 12 31 21 40 39 40 27 0 100 61 109 91 4 10 26 27 50 38 66 29 122 78 148 130 21 41 27 46 61 49 52 4 195 79 209 109 8 17 8 36 0 64-10 37-8 43 13 67 79 88 123 146 136 181 15 39 15 42-5 67-12 16-21 42-21 68-1 33-5 42-21 44-12 2-31-8-45-23-18-19-33-25-65-25-22 0-45-4-51-10-18-18-70-14-100 7-16 11-47 26-69 33s-62 23-90 35c-27 12-62 28-78 34-15 6-32 23-37 38-6 16-19 44-30 64s-20 52-20 70c0 19-9 52-19 74-17 38-17 41-1 65 9 14 27 53 40 88 22 61 23 62 61 62 36 0 39 2 39 29 0 17-11 42-25 59-18 21-25 42-25 70 0 49-10 58-102 86-69 21-74 24-95 66-12 25-22 56-22 69-1 13-17 41-36 62-45 50-45 69-2 69 19 0 37 3 40 7 4 4 32 5 62 4 58-3 66 2 123 77 20 28 25 29 52 19 24-9 32-8 49 7 31 29 55 99 47 145-4 28-2 42 9 51 27 23 16 48-46 99-33 28-64 51-69 51-4 0-13 14-21 31-10 25-10 38-1 62 15 40-5 73-50 85-27 7-41 22-75 80l-42 71 22 16c12 8 28 15 35 15 21 0 142 120 142 141 0 31-38 107-59 118-11 6-33 11-49 11-29 0-29 0-21 43 12 64 12 67-28 84-21 8-40 17-42 19s13 23 33 48c47 57 47 91 3 134-26 25-33 39-29 60 5 34-4 42-92 77-77 30-104 29-190-4-28-11-64-23-79-26-16-3-50-26-76-50-56-52-74-55-97-17-10 15-28 36-41 48l-24 21 36 52c37 56 41 71 25 101-8 15 1 25 57 64 57 39 125 107 151 151 4 7 21 18 37 26 25 12 31 21 33 53 3 39-23 116-40 116-4 0-8 4-8 8s38 20 84 35c62 20 100 40 141 74 52 43 56 50 52 79-5 28 0 36 35 64 24 19 51 56 67 88 41 87 42 88 88 100 35 10 43 16 43 36 0 27-34 53-80 63-35 7-34 3-15 51 24 58 63 83 119 76 49-7 55-14 31-34-19-16-19-34-1-49 10-9 40-10 101-5 80 6 90 10 134 45 31 23 54 53 65 79l17 42 43-6c55-9 70 7 60 60-5 26-23 55-56 90l-48 51 21 49c11 27 22 68 23 91 2 23 15 62 30 88 31 57 32 68 5 111-21 34-25 67-21 166 2 54 5 61 51 112 34 37 52 67 57 93 3 21 15 53 25 71 14 24 19 51 18 95-1 47 4 73 22 107 37 73 130 202 180 250 53 51 93 125 134 253 35 107 31 114-69 124-52 5-75 12-97 31-23 19-36 23-62 18-74-14-145-11-227 9-80 20-85 23-94 53-5 18-20 44-33 58-26 28-35 28-122-13-42-19-63-23-95-19-22 4-59 8-81 9-40 2-84 27-130 73-13 13-28 24-32 24-24-1-85-29-97-46-14-18-15-18-34-1-10 9-25 36-32 60-19 64-38 97-65 109-17 8-27 22-31 47-3 20-8 44-11 54-6 23-117 77-156 77-15 0-51 14-80 30-30 17-65 30-78 30-14 0-54-20-88-45-51-35-67-42-82-34-11 5-19 14-19 19 0 27-34 40-108 40-64 0-79 3-99 21-24 23-58 28-109 16-37-9-78 18-98 68-25 60-91 98-112 64-4-7-12 1-20 19-10 24-22 33-54 42-25 7-55 25-74 45-35 38-130 85-169 85-26 0-27 3-27 49 0 28 5 53 11 57 16 10 4 97-18 134-17 30-17 32 4 73 27 54 36 106 22 123-7 8-31 14-56 14-41 0-50-5-94-49-42-43-49-55-49-90 0-45-26-71-71-71-15 0-51-16-80-35-59-40-71-40-172-2-59 22-59 22-54 58 3 20 14 46 26 58s21 34 21 49c0 29-26 62-48 62-7 0-12 11-12 24 0 41 18 76 45 86 37 14 32 44-12 71-21 12-54 40-74 61l-35 37h-115c-78 0-121-5-135-14-20-13-22-11-33 40-15 66-62 139-112 172-39 26-120 35-166 19-18-7-27-1-53 35-23 33-30 50-25 69 22 87 22 86-48 130-42 27-67 49-71 65-9 34-42 40-105 19-46-15-80-43-95-77-5-13-49 32-93 96-20 28-37 40-71 49l-45 11 7 86c6 80 5 88-18 122-13 20-28 53-32 75-3 21-11 45-17 52-15 19-49 14-82-14z"
                />
                <path
                    id="path9342"
                    d="m11597 2369.7c-46.095-11.542-58.666-26.838-56.86-65.848 1.363-13.934 5.094-82.898 10.014-153.76 4.921-70.858 6.878-131.96 4.087-134.24-2.694-3.2778-14.929-1.4601-28.354 2.2507-29.132 10.213-84.791-6.2835-163.99-49.197-29.587-15.956-62.355-30.213-72.307-31.187-22.891-2.2389-110.37-52.995-146.46-84.658-13.858-12.408-32.887-23.312-39.854-23.993-29.857-2.9203-44.365-39.506-38.719-97.231 4.672-47.772 1.665-58.114-18.479-78.17-12.863-12.311-31.6-26.2-42.255-30.257-13.447-6.339-17.353-17.774-15.016-41.66 3.017-30.853 6.392-34.542 43.195-40.99 21.387-2.9321 45.446-12.636 54.284-20.815 12.213-11.868 10.32-13.057-13.058-10.32-32.724 5.8423-73.616-38.348-69.918-76.168 4.478-45.782 81.208-131.72 146.61-163.51 12.624-5.7987 11.217-11.965-11.62-35.299-14.561-15.491-37.787-34.844-51.039-43.173-30.291-19.039-31.427-38.241-2.75-74.622 20.932-29.101 26.103-30.604 77.856-25.543 29.858 2.9202 55.129 1.3727 55.615-3.6035 0.487-4.9763-1.861-32.335-5.204-59.791-5.767-43.769-10.96-52.315-34.359-59.628-19.516-5.9278-27.694-14.766-26.526-26.709 3.115-31.848 37.905-48.541 87.667-43.674 50.758 4.9644 71.225-9.1101 45.305-31.741-9.174-8.9354-15.892-32.702-16.25-59.866-1.082-40.297 3.872-49.86 40.003-90.536 42.979-49.049 57.788-56.644 99.589-52.555 14.929 1.4601 46.658-4.4796 71.614-13.091 37.387-12.42 49.6-24.287 73.885-67.127 22.003-40.048 36.402-53.712 56.793-56.741 36.705-5.453 71.507 29.099 81.569 80.321 3.83 22.48 18.24 60.061 30.032 83.319 12.885 22.36 22.589 46.419 22.005 52.391s6.718 23.767 17.201 39.864c13.08 20.37 16.401 37.776 10.181 60.277-5.03 20.608-2.703 37.917 6.081 50.833 9.682 14.009 12.052 51.417 8.754 136.5l-4.422 117.13 49.83 127.46c45.633 119.01 48.348 132.33 42.216 195.04-3.602 36.824-15.49 107-25.235 155.28-14.192 62.917-16.604 97.848-10.978 122.51 7.541 35.905-16.3 146.11-39.904 181.98-5.95 9.4658-11.391 24.005-12.169 31.967-0.876 8.9572-12.992 19.83-27.51 24.438-19.786 7.1078-25.443 13.588-22.025 29.999 4.728 23.572 20.934 63.338 37.313 91.064 6.794 12.722 3.441 26.461-15.793 58.742-14.571 25.704-30.094 71.41-37.46 115.9-9.919 60.321-16.55 76.754-35.924 89.93-12.819 7.7892-27.434 13.393-34.401 12.712-5.874-1.5793-30.366-7.9939-52.868-14.214z"
                />
            </g>
            <g>
                {#each newSpots as spot, index}
                    <g
                        role="button"
                        aria-hidden="true"
                        id={spot.id}
                        title={spot.title}
                        transform={spot.transform}
                        on:click={() => zoomOnregion()}
                        on:mouseenter={() => {
                            toggleRegion(spot);
                        }}
                    >
                        {#if spot.appellations}
                            {#each spot.appellations as appellation, index}
                                <path
                                    role="button"
                                    aria-hidden="true"
                                    id={appellation.id}
                                    title={appellation.title}
                                    d={appellation.d}
                                    class={spotted(spot, appellation.title)}
                                    on:click={() => {
                                        enLarge(spot);
                                    }}
                                    on:mouseenter={() => {
                                        toggleAppellation(spot, appellation);
                                    }}
                                ></path>
                            {/each}
                        {/if}

                        {#if spot.sub_wine_regions}
                            {#each spot.sub_wine_regions as sub, index}
                                <g title={sub.title}>
                                    {#each sub.appellations as appellation, index}
                                        <path
                                            role="button"
                                            aria-hidden="true"
                                            id={appellation.id}
                                            title={appellation.title}
                                            d={appellation.d}
                                            class={spotted(
                                                spot,
                                                appellation.title,
                                            )}
                                            on:click={() => {
                                                enLarge(spot);
                                            }}
                                            on:mouseenter={() => {
                                                toggleAppellation(
                                                    spot,
                                                    appellation,
                                                );
                                            }}
                                        ></path>
                                    {/each}
                                </g>
                            {/each}
                        {/if}
                    </g>
                {/each}
            </g>
        </g>
        {#if appellationInfos.usedAppellation && dataMap.isZoomable && dataMap.isVisible}
            <rect
                on:click={() => {
                    reduce();
                }}
                role="button"
                aria-hidden="true"
                in:fade
                out:fade
                x=".42568"
                y=".4257"
                width="1999.1"
                height="1999.1"
                fill="var(--color-teal-950)"
                fill-opacity=".5"
                stroke-width=".85138"
            />
            <g id="g1424" transform={currentMatrix}>
                <g>
                    <g
                        id={appellationInfos.usedSpot.id}
                        title={appellationInfos.usedSpot.title}
                        transform={appellationInfos.usedSpot.transform}
                    >
                        <path
                            in:fade
                            out:fade
                            id={appellationInfos.usedAppellation.id}
                            title={appellationInfos.usedAppellation.title}
                            d={appellationInfos.usedAppellation.d}
                            class={isFiteredEnlarge
                                ? "enlarge_filtered_color"
                                : "enlarge_color"}
                        ></path>
                    </g>
                </g>
            </g>
        {/if}
    </svg>
</div>

<style>
    .grow {
        fill: var(--color-teal-800);
        stroke: var(--color-teal-300);
        stroke-width: 2px;
        transform: scale(1);
        transform-origin: 50% 50%;
        transition: 0.3s;
        transform-box: fill-box;
    }

    .product_grow {
        fill: var(--color-yellow-500);
        stroke: var(--color-yellow-200);
        stroke-width: 2px;
        transform: scale(1);
        transform-origin: 50% 50%;
        transition: 0.3s;
        transform-box: fill-box;
    }

    .grow:focus {
        outline: none;
    }

    .grow_inactive {
        fill: var(--color-teal-700);
        transform: scale(1);
        transform-origin: 50% 50%;
        transition: 0.3s;
        transform-box: fill-box;
        cursor: initial;
    }

    .filtered_color {
        fill: var(--color-red-800);
        stroke: var(--color-red-300);
        stroke-width: 2px;
        transform: scale(1);
        transform-origin: 50% 50%;
        transition: 0.3s;
        transform-box: fill-box;
    }

    .product_filtered_color {
        fill: var(--color-orange-500);
        stroke: var(--color-orange-300);
        stroke-width: 2px;
        transform: scale(1);
        transform-origin: 50% 50%;
        transition: 0.3s;
        transform-box: fill-box;
    }

    .spotted_color {
        fill: var(--color-teal-300) !important;
        transform: scale(1);
        transform-origin: 50% 50%;
        transition: 0.6s;
        transform-box: fill-box;
    }
    .product_spotted_color {
        fill: var(--color-yellow-300) !important;
        transform: scale(1);
        transform-origin: 50% 50%;
        transition: 0.6s;
        transform-box: fill-box;
    }

    .spotted_filtered_color {
        fill: var(--color-red-300);
        stroke: var(--color-red-800);
        stroke-width: 2px;
        transform: scale(1);
        transform-origin: 50% 50%;
        transition: 0.3s;
        transform-box: fill-box;
    }

    .product_spotted_filtered_color {
        fill: var(--color-orange-300);
        stroke: var(--color-orange-500);
        stroke-width: 2px;
        transform: scale(1);
        transform-origin: 50% 50%;
        transition: 0.3s;
        transform-box: fill-box;
    }

    .enlarge_color {
        fill: var(--color-teal-300) !important;
        stroke: var(--color-teal-950);
        stroke-width: 2px;
        transform: scale(2);
        transform-origin: 50% 50%;
        transition: 0.6s;
        transform-box: fill-box;
    }

    .enlarge_filtered_color {
        fill: var(--color-red-300) !important;
        stroke: var(--color-red-800);
        stroke-width: 2px;
        transform: scale(2);
        transform-origin: 50% 50%;
        transition: 0.6s;
        transform-box: fill-box;
    }

    .back_button {
        position: absolute;
        top: 1em;
        left: 1em;
    }
</style>
