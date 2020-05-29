<template>
    <v-container class="mt-3">
        <v-skeleton-loader
            :loading="headers === null || items === null"
            transition="fade-transition"
            type="table"
        >
            <v-data-table
                :headers="headers"
                :items="items"
                :items-per-page="5"
                class="elevation-1"
            >
            </v-data-table>
        </v-skeleton-loader>
    </v-container>
</template>
<script>
const axios = require("axios").default;
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
export default {
    name: "PermissionsMatrix",
    data() {
        return {
            headers: null,
            items: null
        };
    },
    methods: {
        loadHeaders: function() {
            const vm = this;
            axios
                .get("/api/v1/permissions/table/headers")
                .then(function(response) {
                    vm.headers = response.data.headers;
                });
        },
        loadUsers: function() {
            const vm = this;
            axios
                .get("/api/v1/permissions/table/users")
                .then(function(response) {
                    vm.items = response.data.users;
                    console.log(vm.items);
                });
        }
    },
    mounted: function() {
        this.loadHeaders();
        this.loadUsers();
    }
};
</script>
