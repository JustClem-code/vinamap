<script>
    import axios from "axios";
    import { onMount } from "svelte";

    import MainForm from "../CrudComponent/MainForm.svelte";

    let controller = "appellation";
    let title = "appellation";
    let placeholderCreate = "Muscadet";
    let optionItemsTitle = "Région viticole"
    let optionItemsTitle2 = "Cépages"

    let optionItems =[];
    let optionItems2 =[];

    onMount(() => {
        getWineregion();
        getGrapeVariety();
    });

    async function getWineregion() {
        const response = await axios.get(`https://localhost/getwineregions`);
        optionItems = response.data;
    }
    async function getGrapeVariety() {
        const response = await axios.get(`https://localhost/getgrapevarietys`);
        optionItems2 = response.data;
    }

</script>

<MainForm {controller} {title} {placeholderCreate} {optionItems} {optionItemsTitle} {optionItems2} {optionItemsTitle2}/>
