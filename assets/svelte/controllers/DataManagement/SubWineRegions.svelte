<script>
    import axios from "axios";
    import { onMount } from "svelte";

    import MainForm from "../CrudComponent/MainForm.svelte";

    let dataManagement = {
        controller: "subwineregion",
        title: "Sous-région",
        placeholderCreate: "La Côte de Beaune",
        options: {
            itemsTitle: "Région viticole",
            itemsTitle2: "",
            itemsTitle3: "",
            items: null,
            items2: null,
            items3: null,
        },
    };

    onMount(() => {
        getWineregion();
    });

    async function getWineregion() {
        const response = await axios.get(`/getwineregions`);
        dataManagement.options.items = response.data;
    }
</script>

<MainForm {dataManagement} />
