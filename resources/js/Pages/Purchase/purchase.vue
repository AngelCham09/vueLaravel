<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { ref, onMounted, computed } from "vue";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import MultiSelect from "primevue/multiselect";
import Toolbar from "primevue/toolbar";
import InputText from "primevue/inputtext";
import InputIcon from "primevue/inputicon";
import IconField from "primevue/iconfield";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    purchases: {
        type: Object,
        required: true,
    },
    locations: {
        type: Object,
        required: true,
    },
    search: {
        type: String,
    },
    reserves: {
        type: Object,
    },
});

const search = ref(props.search);
const expandedRowGroups = ref();
const selectedReviews = ref();

const expandAll = () => {
    expandedRowGroups.value = props.purchases.map((purchase) => purchase.id);
};

const collapseAll = () => {
    expandedRowGroups.value = [];
};

const reviews = [
    { id: 1, name: "1" },
    { id: 2, name: "2" },
    { id: 3, name: "3" },
];

const columns = ref([]);
const selectedColumns = ref(columns.value);
const onToggle = (val) => {
    selectedColumns.value = columns.value.filter((col) => val.includes(col));
    console.log(selectedColumns.value);
};

const purchases = computed(() => {
    if (selectedColumns.value.length === 0) {
        return props.purchases;
    }

    return props.purchases.filter((purchase) =>
        selectedColumns.value
            .map((loc) => loc.label)
            .includes(purchase.location)
    );
});

const searchForm = () => {
    router.get(
        route("purchase.index"),
        {
            search: search.value,
        },
        { replace: true }
    );
};

onMounted(() => {
    console.log(props.reserves);
    columns.value = Object.keys(props.locations).map((key) => ({
        label: props.locations[key],
        value: key,
    }));
});

const showOptions = ref(false);
const toggleDropdown = () => {
    showOptions.value = !showOptions.value;
};
</script>

<template>
    <Head title="Purchase" />

     <div>
        <div v-for="reserve in reserves" :key="reserve.id">
            <h3>Reserve ID: {{ reserve.id }}</h3>
            <div v-for="deposit in reserve.deposits" :key="deposit.id">
                <p>Deposit ID: {{ deposit.id }}</p>
                <p>Transaction ID: {{ deposit.transaction ? deposit.transaction.id : 'No transaction found' }}</p>
            </div>
        </div>
    </div>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Purchase
            </h2>
        </template>

        <div class="m-10">
            <Toolbar class="mb-4">
                <template #start>
                    <form @submit.prevent="searchForm">
                        <IconField>
                            <InputIcon>
                                <i class="pi pi-search" />
                            </InputIcon>
                            <InputText v-model="search" placeholder="Search" />
                        </IconField>
                    </form>
                </template>

                <template #end>
                    <div>
                        <Button
                            class="me-3"
                            type="button"
                            label="Collapse"
                            @click="collapseAll"
                        />
                        <Button
                            type="button"
                            label="Expand"
                            @click="expandAll"
                        /></div
                ></template>
            </Toolbar>

            <DataTable
                v-model:expandedRowGroups="expandedRowGroups"
                :value="purchases"
                expandableRowGroups
                rowGroupMode="subheader"
                groupRowsBy="id"
                sortMode="single"
                sortField="name"
                :sortOrder="1"
            >
                <template #header>
                    <div style="text-align: left">
                        <MultiSelect
                            :modelValue="selectedColumns"
                            :options="columns"
                            optionLabel="label"
                            @update:modelValue="onToggle"
                            display="chip"
                            placeholder="Select Location"
                        />
                    </div>
                </template>
                <template #groupheader="slotProps">
                    <span @click="toggleDropdown">
                        {{ slotProps.data.staff.name }} |
                        {{ slotProps.data.staff.role }} |
                        {{ slotProps.data.location }} |
                        {{ slotProps.data.created_at }}
                    </span>
                    <Dropdown
                        v-model="selectedReviews"
                        :options="reviews"
                        optionLabel="name"
                        placeholder="Reviews"
                    />


                    <Dropdown
                        v-model="selectedReviews"
                        :options="reviews"
                        optionLabel="name"
                        v-if="showOptions"
                        @hide="showOptions = false"
                        placeholder="Select an option"
                        appendTo="body"
                        :style="{
                            position: 'absolute',
                            top: '100%',
                            left: '0',
                            zIndex: '1000',
                        }"
                    />
                </template>

                <Column header="Tag" :style="{ width: '25%' }">
                    <template #body="slotProps">
                        <Button type="button" label="Tag" />
                    </template>
                </Column>

                <Column header="Name" :style="{ width: '25%' }">
                    <template #body="slotProps">
                        <ul>
                            <li
                                v-for="item in slotProps.data.items"
                                :key="item.id"
                            >
                                {{ item.name }}
                            </li>
                        </ul>
                    </template>
                </Column>

                <Column header="Brand" :style="{ width: '25%' }">
                    <template #body="slotProps">
                        <ul>
                            <li
                                v-for="item in slotProps.data.items"
                                :key="item.id"
                            >
                                {{ item.brand }}
                            </li>
                        </ul>
                    </template>
                </Column>

                <Column header="Price" :style="{ width: '25%' }">
                    <template #body="slotProps">
                        <ul>
                            <li
                                v-for="item in slotProps.data.items"
                                :key="item.id"
                            >
                                {{ item.price }}
                            </li>
                        </ul>
                    </template>
                </Column>
                <Column field="" header="" style="display: none"></Column>
                <template #groupfooter="slotProps">
                    <div class="flex justify-end font-bold w-full">
                        CK + CB + PK + LO = Total Cost:
                        {{ slotProps.data.cost }}
                    </div>
                </template>
            </DataTable>
        </div>
    </AuthenticatedLayout>
</template>
