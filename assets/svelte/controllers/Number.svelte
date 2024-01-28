<script>
    import Nested from './NestedComponent/Nested.svelte';

    export let number;
    export let perso;

    console.log(perso);
</script>

<div>
    <h2 class="text-3xl">nombre aléatoire {number}</h2>
    <Nested number={number}/>

    <ul>
        {#each perso as pers, i}
            <li>
                {pers}
            </li>
        {/each}
    </ul>
</div>
