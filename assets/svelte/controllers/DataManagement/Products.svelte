<script>
    import axios from "axios";
    import { onMount } from "svelte";

    import MainForm from "../CrudComponent/MainForm.svelte";

    let dataManagement = {
        controller: "product",
        title: "produit",
        placeholderCreate: "Les darons de Jeff Carrel",
        options: {
            itemsTitle: "Appellation",
            itemsTitle2: "",
            itemsTitle3: "",
            itemsTitle4: "Milllésime",
            itemsTitle5: "Avis",
            items: null,
            items2: null,
            items3: null,
        },
    };

    onMount(() => {
        getAppellation();
    });

    async function getAppellation() {
        const response = await axios.get(`https://localhost/getappellations`);
        dataManagement.options.items = response.data;
    }
</script>
<MainForm {dataManagement} />
