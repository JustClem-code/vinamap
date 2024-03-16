<script>
    export let createPizza;

    let name = "";

    function submitPizza() {
        createPizza(name);
        name = "";
    }
</script>

<h2 class="text-3xl font-bold text-slate-950">Créer votre pizza</h2>

<form on:submit|preventDefault={submitPizza} class="w-full max-w-sm">
    <div class="flex items-center border-b border-teal-500 py-2">
        <input
            bind:value={name}
            class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
            type="text"
            placeholder="Poulet ananas"
            aria-label="pizza name"
            required
        />
        <button
            class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
            type="submit"
        >
            Créer Pizza
        </button>
    </div>
</form>
