<script>
    import NavContent from "./NavContent.svelte";
    import LogoTitle from "./LogoTitle.svelte";

    export let open = false;
    export let is_user;

</script>

<aside
    class="fixed w-full h-full bg-teal-500 border-r-2 p-6 shadow-lg z-50"
    class:open
>
    <div class="flex items-center justify-between flex-wrap bg-teal-500">
        <LogoTitle />
        <div class="block lg:hidden">
            <button
                class="flex items-center px-3 py-2 text-teal-200 hover:text-white"
                class:open
                on:click={() => (open = !open)}
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>
    </div>
    <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto block lg:hidden">
        <NavContent bind:is_user />
    </div>
</aside>

<style>
    aside {
        left: -100%;
        transition: left 0.3s ease-in-out;
    }

    .open {
        left: 0;
    }
</style>
