<template>
    <v-container class="mt-3">
        <v-row>
            <v-col cols="12" sm="12" lg="6">
                <v-skeleton-loader
                    :loading="user.username == null"
                    transition="fade-transition"
                    type="heading"
                >
                    <h1>{{ user.username }}'s Profile</h1>
                </v-skeleton-loader>
                <br />
                <v-skeleton-loader
                    :loading="user.avatar == null"
                    transition="fade-transition"
                    type="image"
                    width="128"
                    height="128"
                >
                    <img :src="user.avatar" />
                </v-skeleton-loader>
                <br />
                <v-tabs background-color="primary">
                    <v-tab>
                        <v-icon left>mdi-account</v-icon>
                        About
                    </v-tab>
                    <v-tab>
                        <v-icon left>mdi-lock</v-icon>
                        Permissions
                    </v-tab>
                    <v-tab-item>
                        <v-card flat>
                            <v-card-text>
                                <p>
                                    About stuff here
                                </p>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item>
                        <v-skeleton-loader
                            :loading="permissions.values == null"
                            transition="fade-transition"
                            type="table"
                        >
                            <v-data-table
                                :headers="permissions.headers"
                                :items="permissions.values"
                            >
                                <template v-slot:item.perm_value="{ item }">
                                    <v-simple-checkbox
                                        v-model="item.perm_value"
                                        @input="
                                            updatePerm(
                                                item.perm_name,
                                                item.perm_value
                                            )
                                        "
                                    ></v-simple-checkbox>
                                </template>
                            </v-data-table>
                        </v-skeleton-loader>
                    </v-tab-item>
                </v-tabs>
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
                discord: null
            },
            permissions: {
                headers: [
                    { text: "Permission Name", value: "perm_name" },
                    { text: "Has Permission", value: "perm_value" }
                ],
                values: null
            }
        };
    },
    methods: {
        loadUserData: function() {
            const vm = this;
            axios.get("/api/v1/user/details/1").then(function(response) {
                vm.user = response.data;
            });
            axios.get("/api/v1/user/permissions/1").then(function(response) {
                vm.permissions.values = response.data;
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
