<script>
    import Sidebar from "./Sidebar.svelte";
    import NavContent from "./NavContent.svelte";
    import LogoTitle from "./LogoTitle.svelte";

    export let is_user;

    let open = false;

    $: open
        ? (document.body.style.position = "fixed")
        : (document.body.style.position = "");
</script>

<Sidebar bind:open bind:is_user />

<nav class="flex items-center justify-between flex-wrap bg-teal-500 p-6">
    <LogoTitle />
    <div class="block lg:hidden">
        <button
            class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white"
            on:click={() => (open = !open)}
        >
            <svg
                class="fill-current h-3 w-3"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
                ><title>Menu</title><path
                    d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"
                /></svg
            >
        </button>
    </div>
    <div
        class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block"
    >
        <NavContent bind:is_user />
    </div>
</nav>
