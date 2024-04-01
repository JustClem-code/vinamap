<script>
    import MainForm from "../CrudComponent/MainForm.svelte";

    let controller = "grapevariety";
    let title = "Cépage";
    let placeholderCreate = "Syrah";
</script>

<MainForm {controller} {title} {placeholderCreate} />
