<script>
    import MainForm from "../CrudComponent/MainForm.svelte";

    let controller = "wineregion";
    let title = "région";
    let placeholderCreate = "Savoie";
</script>

<MainForm {controller} {title} {placeholderCreate} />
