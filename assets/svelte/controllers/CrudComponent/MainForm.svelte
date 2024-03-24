<script>
    import axios from "axios";
    import { onMount } from "svelte";

    import AddForm from "./AddForm.svelte";
    import EditForm from "./EditForm.svelte";
    import DeleteForm from "./DeleteForm.svelte";
    import Dialog from "../UI/Dialog.svelte";
    import Alert from "../UI/Alert.svelte";

    export let controller;
    export let title;
    export let placeholderCreate;

    let dialog;
    let showdialogEdit = false;
    let showdialogDelete = false;
    let onLoad = false;
    let items = [];
    let itemIdDialog;
    let itemNameDialog;

    onMount(() => {
        onLoad = true;
        getItems();
    });

    async function getItems() {
        const response = await axios.get(`https://localhost/get${controller}s`);
        items = response.data;
        onLoad = false;
    }

    async function createItem(name) {
        await axios
            .post(`https://localhost/create${controller}`, { name })
            .then((res) => {
                isSuccess = true;
                alertString = "Created" + " " + res.data.name;
                resetAlert();
                getItems();
            })
            .catch((error) => {
                console.log(error);
                isSuccess = false;
                alertString = error.response.data.errors;
                resetAlert();
            });
    }

    async function editItem(id, name) {
        await axios
            .post(`https://localhost/update${controller}/${id}`, { name })
            .then((res) => {
                isSuccess = true;
                alertString = "Updated" + "" + res.data.name;
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
            .post(`https://localhost/delete${controller}/${id}`, {
                method: "DELETE",
            })
            .then((res) => {
                isSuccess = true;
                alertString = res.data;
                resetAlert();
                getItems();
                dialog.close();
                showdialogDelete = false;
            });
    }

    function editDialogItem(itemId, itemName) {
        showdialogEdit = true;
        itemIdDialog = itemId;
        itemNameDialog = itemName;
        dialog.showModal();
    }

    function deleteDialogItem(itemId) {
        showdialogDelete = true;
        itemIdDialog = itemId;
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

    $: items.sort((a, b) =>
        a.name.toLowerCase().localeCompare(b.name.toLowerCase()),
    );
</script>

<div class="p-10">
    {#if alertString != ""}
        <Alert message={alertString} {isSuccess} />
    {/if}

    <div class="py-4">
        <AddForm
            addForm={createItem}
            titleForm={title}
            placeholder={placeholderCreate}
        />
    </div>

    <h2 class="text-3xl font-bold text-slate-950">Liste des {title}s</h2>

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
            {#each items as item, i}
                <li
                    class="flex flex-col sm:flex-row justify-between items-center gap-1 p-1 my-2 border-2 hover:border-gray-300 rounded"
                >
                    <div class="pl-4">
                        {i + 1}
                        {item.name}
                    </div>
                    <div class="flex items-center gap-1">
                        <button
                            on:click={() => editDialogItem(item.id, item.name)}
                            class="bg-transparent hover:bg-teal-500 text-teal-700 font-semibold hover:text-white py-2 px-4 border border-teal-500 hover:border-transparent rounded"
                        >
                            Modifier
                        </button>

                        <button
                            on:click={() => deleteDialogItem(item.id)}
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
                editId={itemIdDialog}
                name={itemNameDialog}
                closeModal={() => dialog.close()}
                {editItem}
            />
        {:else if showdialogDelete}
            <DeleteForm
                {title}
                editId={itemIdDialog}
                closeModal={() => dialog.close()}
                {deleteItem}
            />
        {/if}
    </Dialog>
</div>
