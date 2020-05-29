<template>
    <v-container class="mt-3">
        <v-skeleton-loader
            :loading="user.username == null && user.avatar == null"
            type="list-item-avatar"
        >
            <v-avatar><img :src="user.avatar"/></v-avatar>
            <h1>{{ user.username }}'s Profile</h1>
        </v-skeleton-loader>
        <v-row>
            <v-col cols="12" sm="12" lg="6">
                <v-skeleton-loader
                    :loading="user.permissions == null"
                    type="table"
                >
                    <v-data-table :headers="headers" :items="user.permissions">
                        <template v-slot:item.perm_value="{ item }">
                            <v-simple-checkbox
                                v-model="item.perm_value"
                                @input="
                                    updatePerm(item.perm_name, item.perm_value)
                                "
                            ></v-simple-checkbox>
                        </template>
                    </v-data-table>
                </v-skeleton-loader>
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
    name: "PermissionsMatrix",
    props: ["id"],
    data() {
        return {
            user: {
                username: null,
                avatar: null,
                discord: null,
                permissions: null
            },
            headers: [
                { text: "Permission Name", value: "perm_name" },
                { text: "Has Permission", value: "perm_value" }
            ]
        };
    },
    methods: {
        loadUserData: function() {
            const vm = this;
            axios.get("/api/v1/user/details/1").then(function(response) {
                vm.user = response.data;
            });
        },
        updatePerm: function($permName, $permValue) {
            console.log($permName + " lol " + $permValue);
        }
    },
    mounted: function() {
        this.loadUserData();
    }
};
</script>
