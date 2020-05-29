<template>
    <v-skeleton-loader
        :loading="donations == null"
        transition-group="fade-transition"
        type="list-item-avatar-two-line, list-item-avatar-two-line, list-item-avatar-two-line, list-item-avatar-two-line, list-item-avatar-two-line"
    >
        <v-timeline :dense="true">
            <v-timeline-item v-for="donation in donations" :key="donation.id">
                <template v-slot:icon>
                    <v-avatar>
                        <v-img
                            :src="
                                'https://crafatar.com/avatars/' +
                                    donation.player.uuid +
                                    '.png'
                            "
                        />
                    </v-avatar>
                </template>
                <v-card class="elevation-2">
                    <v-card-title class="headline">{{
                        donation.player.name
                    }}</v-card-title>
                    <v-card-text>{{
                        donation.currency.symbol + donation.amount
                    }}</v-card-text>
                </v-card>
            </v-timeline-item>
        </v-timeline>
    </v-skeleton-loader>
</template>

<script>
const axios = require("axios").default;
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
export default {
    name: "Donations",
    data: () => ({
        donations: null
    }),
    methods: {
        loadDonations: function() {
            var vm = this;
            axios.get("/api/v1/donations/5").then(function(response) {
                vm.donations = response.data.items;
            });
        }
    },
    mounted: function() {
        this.loadDonations();
    }
};
</script>
