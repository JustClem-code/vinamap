<script>
    import MainForm from "../CrudComponent/MainForm.svelte";

    let dataManagement = {
        controller: "grapevariety",
        title: "Cépage",
        placeholderCreate: "Syrah",
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
