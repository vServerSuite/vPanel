<template>
    <v-container class="mt-3">
        <v-row>
            <v-col cols="12" sm="6" lg="3">
                <v-skeleton-loader
                    :loading="currentPlayers == null"
                    transition="fade-transition"
                    type="card"
                >
                    <statistic title="Current Players" color="#FF1744">
                        {{ currentPlayers }}
                    </statistic>
                </v-skeleton-loader>
            </v-col>
            <v-col cols="12" sm="6" lg="3">
                <v-skeleton-loader
                    :loading="totalPlayers == null"
                    transition="fade-transition"
                    type="card"
                >
                    <statistic title="Players" color="#0091EA">{{
                        totalPlayers
                    }}</statistic>
                </v-skeleton-loader>
            </v-col>
            <v-col cols="12" sm="6" lg="6">
                <donations></donations>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
const axios = require("axios").default;
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
export default {
    name: "Dashboard",
    data() {
        return {
            currentPlayers: null,
            totalPlayers: null
        };
    },
    methods: {
        loadCurrentPlayers: function() {
            var vm = this;
            axios.get(`/api/v1/onlineplayers`).then(function(response) {
                vm.currentPlayers = response.data.players.length;
            });
        },
        loadTotalPlayers: function() {
            var vm = this;
            axios.get("/api/v1/players").then(function(response) {
                vm.totalPlayers = response.data.length;
            });
        }
    },
    mounted: function() {
        this.loadCurrentPlayers();
        this.loadTotalPlayers();
    }
};
</script>
