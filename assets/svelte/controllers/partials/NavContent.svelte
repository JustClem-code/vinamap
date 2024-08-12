<script>
    export let is_user;
</script>

<div class="text-sm lg:flex-grow">
    <a
        href="/"
        class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4"
    >
        Accueil
    </a>
    {#if is_user}
        <a
            href="/product"
            class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4"
        >
            Produits
        </a>
        <a
            href="/wineregions"
            class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4"
        >
            Régions viticoles
        </a>
        <a
            href="/subwineregions"
            class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4"
        >
            Sous-régions viticoles
        </a>
        <a
            href="/grapevarietys"
            class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4"
        >
            Cépages
        </a>
        <a
            href="/appellations"
            class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4"
        >
            Appellations
        </a>
    {/if}
    <a
        href="/login"
        class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white"
    >
        Login/Logout
    </a>
</div>
