<script>
    import MainForm from "../CrudComponent/MainForm.svelte";

    let controller = "appellation";
    let title = "appellation";
    let placeholderCreate = "Muscadet";
</script>

<MainForm {controller} {title} {placeholderCreate} />
