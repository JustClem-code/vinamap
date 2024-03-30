<script>
    import { onMount } from "svelte";

    export let editItem;
    export let name;
    export let editId;
    export let option;
    export let optionItemsTitle;
    export let optionItems;
    export let closeModal;


    $: optionValue = option;

    onMount(() => {
        const element1 = document.getElementById("first-input-edit");
        element1.focus();
    });

    function submitForm() {
        editItem(editId, name, optionValue);
    }

    function submit(event) {
        if (event.key === "Enter") {
            submitForm();
        }
    }
</script>

<svelte:window on:keydown={submit} />

<div
    class="relative z-10"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    <div
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
    ></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div
            class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
        >
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
            >
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3
                            class="text-base font-semibold leading-6 text-gray-900"
                            id="modal-title"
                        >
                            Modifier
                        </h3>

                        <form
                            on:submit|preventDefault={submitForm}
                            class="w-full max-w-lg"
                        >
                            <div class="flex flex-wrap mb-6">
                                <div class="w-full">
                                    <label
                                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                        for="grid-password"
                                    >
                                        Nom
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        bind:value={name}
                                        id="first-input-edit"
                                        type="text"
                                        placeholder={name}
                                        required
                                    />
                                </div>
                            </div>

                            {#if optionItems != null}
                                <div class="flex flex-wrap mb-6">
                                    <div class="w-full md:w-1/3 mb-6 md:mb-0">
                                        <label
                                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                            for="grid-state"
                                        >
                                            {optionItemsTitle}
                                        </label>
                                        <div class="relative">
                                            <select
                                                bind:value={optionValue}
                                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                id="grid-state"
                                            >
                                                {#each optionItems as optonItem}
                                                    <option value={optonItem.id}
                                                        >{optonItem.name}</option
                                                    >
                                                {/each}
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                                            >
                                                <svg
                                                    class="fill-current h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    ><path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                                    /></svg
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {/if}

                            <div>
                                <button
                                    class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 border-4 text-white py-1 px-2 rounded"
                                    type="submit"
                                >
                                    Modifier
                                </button>
                                <button
                                    on:click={closeModal}
                                    class="flex-shrink-0 border-transparent border-4 text-teal-500 hover:text-teal-800 py-1 px-2 rounded"
                                    type="button"
                                >
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
