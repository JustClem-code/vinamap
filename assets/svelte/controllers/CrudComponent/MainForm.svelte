<script>
    import axios from "axios";
    import { onMount } from "svelte";
    import { writable } from "svelte/store";

    import AddForm from "./AddForm.svelte";
    import ListFilter from "./ListFilter.svelte";
    import EditForm from "./EditForm.svelte";
    import DeleteForm from "./DeleteForm.svelte";
    import Dialog from "../UI/Dialog.svelte";
    import Alert from "../UI/Alert.svelte";

    export let dataManagement;

    let dialog;
    let showdialogEdit = false;
    let showdialogDelete = false;
    let onLoad = false;

    let currentItem = null;

    const items = writable([]);

    onMount(() => {
        onLoad = true;
        getItems();
    });

    $: $items.sort((a, b) =>
        a.name.toLowerCase().localeCompare(b.name.toLowerCase()),
    );

    // FILTER

    let filterValue = [];
    let filterValue2 = [];
    let filterValue3 = [];

    $: filterItems = $items;

    function regionFilter(itemsArray, filterArray) {
        filterItems = itemsArray.filter((item) => {
            return filterArray.some((f) => {
                return Object.values(item).includes(f.label);
            });
        });
    }

    function grapeFilter(ar) {
        filterItems = ar.filter(({ grapevarietyCollection }) => {
            return grapevarietyCollection.some(({ grapevarietyId }) => {
                return filterValue2.some((f) => {
                    return f.value === grapevarietyId;
                });
            });
        });
    }

    $: if (filterValue.length) {
        regionFilter($items, filterValue);

        if (filterValue2.length) {
            grapeFilter(filterItems);
        }

        if (filterValue3.length) {
            regionFilter(filterItems, filterValue3);
        }
    } else if (filterValue2.length) {
        grapeFilter($items);

        if (filterValue3.length) {
            regionFilter(filterItems, filterValue3);
        }
    } else if (filterValue3.length) {
        regionFilter($items, filterValue3);
    } else {
        filterItems = $items;
    }

    // FILTER

    async function getItems() {
        const response = await axios.get(
            `https://localhost/get${dataManagement.controller}s`,
        );
        items.set(response.data);
        onLoad = false;
        return items;
    }

    async function createItem(formData) {
        await axios
            .post(`https://localhost/create${dataManagement.controller}`, {
                formData,
            })
            .then((res) => {
                isSuccess = true;
                alertString = "Created" + " " + res.data.name;
                resetAlert();
                getItems();
            })
            .catch((error) => {
                isSuccess = false;
                alertString = error.response.data.errors;
                resetAlert();
            });
    }

    async function editItem(formData) {
        await axios
            .post(
                `https://localhost/update${dataManagement.controller}/${formData.id}`,
                {
                    formData
                },
            )
            .then((res) => {
                isSuccess = true;
                alertString = "Updated" + " " + res.data.name;
                resetAlert();
                getItems();
                showdialogEdit = false;
                dialog.close();
            })
            .catch((error) => {
                isSuccess = false;
                alertString = error.response.data.errors;
                resetAlert();
            });
    }

    async function deleteItem(id) {
        await axios
            .post(
                `https://localhost/delete${dataManagement.controller}/${id}`,
                {
                    method: "DELETE",
                },
            )
            .then((res) => {
                isSuccess = true;
                alertString = res.data;
                resetAlert();
                getItems();
                dialog.close();
                showdialogDelete = false;
            });
    }

    function testEditDialogItem(item) {
        showdialogEdit = true;
        currentItem = item;
        dialog.showModal();
    }

    function deleteDialogItem(item) {
        showdialogDelete = true;
        currentItem = item;
        dialog.showModal();
    }

    function resetAlert() {
        setTimeout(() => {
            alertString = "";
        }, 3000);
    }

    function onClose() {
        showdialogEdit = false;
        showdialogDelete = false;
    }

    $: alertString = "";
    $: isSuccess = false;
</script>

<div class="p-10">
    {#if alertString != ""}
        <Alert message={alertString} {isSuccess} />
    {/if}

    <div class="py-4">
        <AddForm addForm={createItem} {dataManagement} />
    </div>

    {#if dataManagement.options.items != null || dataManagement.options.items3 != null || dataManagement.options.items3 != null}
        <div class="py-4">
            <ListFilter
                dataOptions={dataManagement.options}
                bind:filterValue
                bind:filterValue2
                bind:filterValue3
            />
        </div>
    {/if}

    <h2 class="text-3xl font-bold text-slate-950">
        Liste des {dataManagement.title}s
    </h2>

    <ul>
        {#if onLoad}
            {#each Array(6) as _, i}
                <li
                    class="animate-pulse flex flex-col sm:flex-row justify-between items-center gap-1 p-1 my-2 border-2 hover:border-gray-300 rounded"
                >
                    <div class="pl-4 flex items-center gap-1">
                        <div class="h-2 w-2 bg-slate-400 rounded-full"></div>
                        <div class="h-4 w-20 bg-slate-400 rounded-full"></div>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="h-11 w-24 bg-slate-400 rounded"></div>
                        <div class="h-11 w-28 bg-slate-400 rounded"></div>
                    </div>
                </li>
            {/each}
        {:else}
            {#each filterItems as item, i}
                <li
                    class="flex flex-col sm:flex-row justify-between items-center gap-1 p-1 my-2 border-2 hover:border-gray-300 rounded"
                >
                    <div class="pl-4">
                        {i + 1}
                        {item.name}
                    </div>

                    {#if item.wineregionId != null}
                        <div class="pl-4">
                            {item.wineregionName}
                        </div>
                    {/if}
                    {#if item.subwineregionId != null}
                        <div class="pl-4">
                            {item.subwineregionName}
                        </div>
                    {/if}
                    {#if item.grapevarietyCollection != null}
                        <div class="flex pl-4 gap-1">
                            {#each item.grapevarietyCollection as grape, i}
                                <div>
                                    {grape.grapevarietyName}
                                </div>
                            {/each}
                        </div>
                    {/if}
                    <div class="flex items-center gap-1">
                        <button
                            on:click={() =>
                                testEditDialogItem(item)}
                            class="bg-transparent hover:bg-teal-500 text-teal-700 font-semibold hover:text-white py-2 px-4 border border-teal-500 hover:border-transparent rounded"
                        >
                            Modifier
                        </button>

                        <button
                            on:click={() => deleteDialogItem(item)}
                            class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded"
                        >
                            Supprimer
                        </button>
                    </div>
                </li>
            {/each}
        {/if}
    </ul>

    <Dialog bind:dialog on:close={() => onClose()}>
        {#if showdialogEdit}
            <EditForm
                {currentItem}
                dataOptions={dataManagement.options}
                closeModal={() => dialog.close()}
                {editItem}
            />
        {:else if showdialogDelete}
            <DeleteForm
                title={dataManagement.title}
                id={currentItem.id}
                closeModal={() => dialog.close()}
                {deleteItem}
            />
        {/if}
    </Dialog>
</div>
