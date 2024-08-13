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
            itemsTitle4: "Maison",
            itemsTitle5: "Milllésime",
            itemsTitle6: "Avis",
            items: null,
            items2: null,
            items3: null,
        },
    };

    onMount(() => {
        getAppellation();
    });

    async function getAppellation() {
        const response = await axios.get(`/getappellations`);
        dataManagement.options.items = response.data;
    }
</script>
<MainForm {dataManagement} />
