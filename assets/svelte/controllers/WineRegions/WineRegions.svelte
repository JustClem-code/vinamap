<script>
    import axios from "axios";
    import { onMount } from "svelte";

    import AddForm from "./../CrudComponent/AddForm.svelte";
    import EditForm from "./../CrudComponent/EditForm.svelte";
    import DeleteForm from "./../CrudComponent/DeleteForm.svelte";
    import Dialog from "./../UI/Dialog.svelte";
    import Alert from "./../UI/Alert.svelte";

    let title = "région";
    let dialog;
    let showdialogEdit = false;
    let showdialogDelete = false;
    let items = [];
    let itemIdDialog;
    let itemNameDialog;

    onMount(() => {
        getItems();
    });

    async function getItems() {
        const response = await axios.get("https://localhost/getwineregions");
        items = response.data;
    }

    async function createItem(name) {
        await axios
            .post("https://localhost/createwineregion", { name })
            .then((res) => {
                isSuccess = true;
                alertString = 'Created' + ' ' + res.data.name;
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
            .post(`https://localhost/updatewineregion/${id}`, { name })
            .then((res) => {
                isSuccess = true;
                alertString = 'Updated' + '' + res.data.name;
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
            .post(`https://localhost/deletewineregion/${id}`, {
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

<div class="p-2">
    {#if alertString != ""}
        <Alert message={alertString} {isSuccess} />
    {/if}

    <div class="py-4">
        <AddForm
            addForm={createItem}
            titleForm={title}
            placeholder={"Savoie"}
        />
    </div>

    <h2 class="text-3xl font-bold text-slate-950">Liste des {title}s</h2>

    <ul>
        {#each items as item, i}
            <li
                class="flex justify-between items-center p-1 m-2 border-2 hover:border-gray-300 rounded"
            >
                <div class="pl-4">
                    {i + 1}
                    {item.name}
                </div>
                <div>
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
