<script>
    export let pizzaCollection;
    export let createPizz;

    $: doubled = createPizz * 2;

    function handleClick() {
        createPizz += 1;
    }

    console.log(pizzaCollection);
    console.log('createPizz', createPizz);
</script>

<div>
    <h2 class="text-3xl font-bold ">Pizza</h2>

    <button on:click={handleClick}>
        Clicked {createPizz} {createPizz === 1 ? 'time' : 'times'}
    </button>

    <p>{createPizz} doubled is {doubled}</p>

    <ul>
        {#each pizzaCollection as pizza, i}
            <li>
                {pizza.name}
            </li>
        {/each}
    </ul>
</div>
