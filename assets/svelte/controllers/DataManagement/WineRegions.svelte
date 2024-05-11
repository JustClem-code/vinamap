<script>
    import MainForm from "../CrudComponent/MainForm.svelte";

    let dataManagement = {
        controller: "wineregion",
        title: "région",
        placeholderCreate: "Savoie",
        options: {
            itemsTitle: "",
            itemsTitle2: "",
            itemsTitle3: "",
            items: null,
            items2: null,
            items3: null,
        },
    };

</script>

<MainForm {dataManagement} />
