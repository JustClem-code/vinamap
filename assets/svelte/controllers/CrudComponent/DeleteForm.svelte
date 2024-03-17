<script>
    export let title;
    export let deleteItem;
    export let editId;
    export let closeModal;

    function submit(event) {
        if (event.key === "Enter") {
            deleteItem(editId);
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
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-fit sm:max-w-lg"
            >
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3
                            class="text-base font-semibold leading-6 text-gray-900"
                            id="modal-title"
                        >
                            Supprimer {title} ?
                        </h3>
                        <form
                            on:submit|preventDefault={deleteItem(editId)}
                            class="w-full"
                        >
                            <div class="flex items-center justify-between py-2">
                                <button
                                    class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
                                    type="submit"
                                >
                                    Supprimer
                                </button>
                                <button
                                    on:click={closeModal}
                                    class="flex-shrink-0 border-transparent border-4 text-teal-500 hover:text-teal-800 text-sm py-1 px-2 rounded"
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
