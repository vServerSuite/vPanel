<template>
    <v-app id="inspire">
        <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <v-toolbar color="primary" dark flat>
                                <v-toolbar-title>Login form</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-form>
                                    <v-text-field
                                        v-model="email"
                                        label="Login"
                                        name="login"
                                        prepend-icon="person"
                                        type="text"
                                        required
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="password"
                                        label="Password"
                                        name="password"
                                        prepend-icon="lock"
                                        type="password"
                                        required
                                    ></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" @click="attemptLogin()"
                                    >Login</v-btn
                                >
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
const axios = require("axios").default;
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
export default {
    name: "LoginForm",
    props: {
        action: "null"
    },
    data() {
        return {
            email: null,
            password: null
        };
    },
    methods: {
        attemptLogin: function() {
            var vm = this;
            let service = axios.create({
                responseType: "json"
            });
            axios
                .post("/login", {
                    email: vm.email,
                    password: vm.password
                })
                .then(function(response) {
                    if (response.data.errors == null) {
                        vm.$toast.success("Successfully logged in");
                        window.location.href = "/";
                    } else {
                        vm.$toast.error("Email or password was incorrect");
                    }
                });
        }
    }
};
</script>
