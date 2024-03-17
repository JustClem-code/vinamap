<script>
    import axios from "axios";

    import AddPizzaForm from "./NestedComponent/AddPizzaForm.svelte";
    import DialogEditPizza from "./NestedComponent/DialogEditPizza.svelte";
    import DialogDeletePizza from "./NestedComponent/DialogDeletePizza.svelte";
    import Dialog from "./UI/Dialog.svelte";
    import Alert from "./UI/Alert.svelte";
    import { onMount } from "svelte";

    let dialog;
    let showdialogEdit = false;
    let showdialogDelete = false;
    let pizzas = [];
    let pizzaIdV;
    let pizzaNameV;

    onMount(() => {
        getPizzas();
    });

    async function getPizzas() {
        const response = await axios.get("https://localhost/getpizzas");
        pizzas = response.data;
    }

    async function createPizza(name) {
        await axios
            .post("https://localhost/createpizza", { name })
            .then(() => {
                getPizzas();
            })
            .catch((error) => {
                console.log(error);
                erroString = error.response.data.errors;
                setTimeout(() => {
                    erroString = "";
                }, 3000);
            });
    }

    async function editPizza(id, name) {
        await axios
            .post(`https://localhost/updatepizza/${id}`, { name })
            .then(() => {
                getPizzas();
                showdialogEdit = false;
                dialog.close();
            })
            .catch((error) => {
                erroString = error.response.data.errors;
                setTimeout(() => {
                    erroString = "";
                }, 3000);
            });
    }

    async function deletePizza(id) {
        await axios
            .post(`https://localhost/deletepizza/${id}`, {
                method: "DELETE",
            })
            .then(() => {
                getPizzas();
                dialog.close();
                showdialogDelete = false;
            });
    }

    function editPost(pizzaId, pizzaName) {
        showdialogEdit = true;
        pizzaIdV = pizzaId;
        pizzaNameV = pizzaName;
        dialog.showModal();
    }

    function deletePost(pizzaId) {
        showdialogDelete = true;
        pizzaIdV = pizzaId;
        dialog.showModal();
    }

    function onClose() {
        showdialogEdit = false;
        showdialogDelete = false;
    }

    $: erroString = "";

    $: pizzas.sort((a, b) =>
        a.name.toLowerCase().localeCompare(b.name.toLowerCase()),
    );
</script>

<div class="p-2">
    {#if erroString != ""}
        <Alert message={erroString} />
    {/if}

    <div class="py-4">
        <AddPizzaForm addForm={createPizza} />
    </div>

    <h2 class="text-3xl font-bold text-slate-950">Toutes nos pizzas</h2>

    <ul>
        {#each pizzas as pizza, i}
            <li
                class="flex justify-between items-center p-1 m-2 border-2 hover:border-gray-300 rounded"
            >
                <div class="pl-4">
                    {i + 1}
                    {pizza.name}
                </div>
                <div>
                    <button
                        on:click={() => editPost(pizza.id, pizza.name)}
                        class="bg-transparent hover:bg-teal-500 text-teal-700 font-semibold hover:text-white py-2 px-4 border border-teal-500 hover:border-transparent rounded"
                    >
                        Modifier
                    </button>

                    <button
                        on:click={() => deletePost(pizza.id)}
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
            <DialogEditPizza
                editId={pizzaIdV}
                name={pizzaNameV}
                closeModal={() => dialog.close()}
                {editPizza}
            />
        {:else if showdialogDelete}
            <DialogDeletePizza
                editId={pizzaIdV}
                closeModal={() => dialog.close()}
                {deletePizza}
            />
        {/if}
    </Dialog>
</div>
