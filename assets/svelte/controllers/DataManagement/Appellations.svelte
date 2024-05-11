<script>
    import axios from "axios";
    import { onMount } from "svelte";

    import MainForm from "../CrudComponent/MainForm.svelte";

    let dataManagement = {
        controller: "appellation",
        title: "appellation",
        placeholderCreate: "Muscadet",
        options: {
            itemsTitle: "Région viticole",
            itemsTitle2: "Cépages",
            itemsTitle3: "Sous-région viticole",
            items: null,
            items2: null,
            items3: null,
        },
    };

    onMount(async () => {
        getWineregion();
        getGrapeVariety();
        getSubwineregion();
    });

    async function getWineregion() {
        const response = await axios.get(`https://localhost/getwineregions`);
        dataManagement.options.items = response.data;
    }
    async function getGrapeVariety() {
        const response = await axios.get(`https://localhost/getgrapevarietys`);
        dataManagement.options.items2 = response.data;
    }
    async function getSubwineregion() {
        const response = await axios.get(`https://localhost/getsubwineregions`);
        dataManagement.options.items3 = response.data;
    }
</script>

<MainForm {dataManagement} />
