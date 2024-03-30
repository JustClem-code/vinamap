<script>
    import axios from "axios";
    import { onMount } from "svelte";

    import MainForm from "../CrudComponent/MainForm.svelte";

    let controller = "appellation";
    let title = "appellation";
    let placeholderCreate = "Muscadet";
    let optionItemsTitle = "Région viticole"

    let optionItems =[];

    onMount(() => {
        getWineregion();
    });

    async function getWineregion() {
        const response = await axios.get(`https://localhost/getwineregions`);
        optionItems = response.data;
    }

</script>

<MainForm {controller} {title} {placeholderCreate} {optionItems} {optionItemsTitle}/>
