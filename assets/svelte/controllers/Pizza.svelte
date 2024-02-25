<script>
    import axios from "axios";

    import AddPizzaForm from "./NestedComponent/AddPizzaForm.svelte";
    import DialogEditPizza from "./NestedComponent/DialogEditPizza.svelte";
    import Dialog from "./UI/Dialog.svelte";
    let dialog;

    import { onMount } from "svelte";

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

    function createPizza(name) {
        axios
            .post("https://localhost/createpizza", { name })
            .then(() => {
                getPizzas();
            })
            .catch((error) => {
                console.log("res", error);
            });
    }

    async function editPizza(id, name) {
        await axios
            .post(`https://localhost/updatepizza/${id}`, { name })
            .then(() => {
                getPizzas();
                dialog.close();
            })
            .catch((error) => {
                console.log("res", error);
            });
    }

    async function deletePost(id) {
        await axios
            .post(`https://localhost/deletepizza/${id}`, {
                method: "DELETE",
            })
            .then(() => {
                getPizzas();
            });
    }

    function editPost(pizzaId, pizzaName) {
        pizzaIdV = pizzaId;
        pizzaNameV = pizzaName;
        dialog.showModal();
    }

    $: pizzas.sort((a, b) =>
        a.name.toLowerCase().localeCompare(b.name.toLowerCase()),
    );
</script>

<div>
    <div class="py-4">
        <AddPizzaForm {createPizza} />
    </div>

    <h2 class="text-3xl font-bold text-slate-950">Toutes nos pizzas</h2>

    <ul>
        {#each pizzas as pizza, i}
            <li
                class="flex justify-between items-center p-1 m-2 border-2 rounded"
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

    <Dialog bind:dialog on:close={() => console.log("closed")}>
        <DialogEditPizza
            editId={pizzaIdV}
            name={pizzaNameV}
            closeModal={() => dialog.close()}
            {editPizza}
        />
    </Dialog>
</div>
