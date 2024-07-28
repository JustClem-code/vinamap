<script>
    export let filterProducts;
</script>

<div class="rounded overflow-hidden shadow-lg m-4">
    <div class="px-6 py-4">
        <div class="flex justify-between">
            <div class="mb-2">
                <span class="font-bold text-xl mb-2"
                    >Vos produits de cette appellation</span
                >
            </div>

            <div
                class="font-medium text-blue-500 underline hover:text-blue-700"
            ></div>
        </div>
    </div>
    <div class="px-6 pt-4 pb-2">
        {#each filterProducts as product}
            <span
                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
                >{product.name}</span
            >
        {/each}
    </div>
</div>
