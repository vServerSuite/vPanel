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
                <v-card>
                    <v-tabs>
                        <v-tab>
                            <v-icon left>mdi-account</v-icon>
                            About
                        </v-tab>
                        <v-tab v-if="can('Edit Permissions')">
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
                        <v-tab-item v-if="can('Edit Permissions')">
                            <v-skeleton-loader
                                :loading="permissions.values == null"
                                transition="fade-transition"
                                type="table"
                            >
                                <v-data-table
                                    :headers="permissions.headers"
                                    :items="permissions.values"
                                >
                                    <template
                                        v-slot:item.permission_value="{ item }"
                                    >
                                        <v-simple-checkbox
                                            v-model="item.permission_value"
                                            @input="
                                                updatePerm(
                                                    item.permission_name,
                                                    item.permission_value
                                                )
                                            "
                                        ></v-simple-checkbox>
                                    </template>
                                </v-data-table>
                            </v-skeleton-loader>
                        </v-tab-item>
                    </v-tabs>
                </v-card>
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
    name: "UserProfile",
    props: {
        user_id: null
    },
    data() {
        return {
            user: {
                username: null,
                avatar: null,
                discord: null
            },
            permissions: {
                headers: [
                    { text: "Permission Name", value: "permission_name" },
                    { text: "Has Permission", value: "permission_value" }
                ],
                values: null
            }
        };
    },
    methods: {
        loadUserData: function() {
            const vm = this;
            axios.get(`/api/v1/user/details/${vm.user_id}`).then(function(response) {
                if (response.data.error != null) {
                    vm.$toast.error(
                        `Error whilst loading user details: '${response.data.error}'`
                    );
                } else {
                    vm.user = response.data;
                }
            });
        },
        loadPermissions: function() {
            const vm = this;
            axios.get(`/api/v1/user/permissions/${vm.user_id}`).then(function(response) {
                if (response.data.error != null) {
                    vm.$toast.error(
                        `Error whilst loading user permissions: '${response.data.error}'`
                    );
                } else {
                    vm.permissions.values = response.data;
                }
            });
        },
        updatePerm: function($permName, $permValue) {
            if (this.can("Edit Permissions")) {
                const vm = this;
                axios
                    .post(`/api/v1/user/permissions/${vm.user_id}`, {
                        permission_name: $permName,
                        permission_value: $permValue
                    })
                    .then(function(response) {
                        if (response.data.success) {
                            vm.$toast.success(
                                `Permissions updated for ${vm.user.username}`
                            );
                        } else {
                            vm.$toast.error(
                                `Could not update permissions for ${vm.user.username}: '${response.data.error}'`
                            );
                        }
                    });
            } else {
                vm.$toast.error("Access Denied");
            }
        }
    },
    mounted: function() {
        this.loadUserData();
        if (this.can("View Permissions")) {
            this.loadPermissions();
        }
    }
};
</script>
