<template>
    <v-col
        cols="12"
        sm="8"
        md="4"
    >
        <v-card class="elevation-12">
            <v-toolbar
                color="primary"
                dark
                flat
            >
                <v-toolbar-title>Registration</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn
                            :href="source"
                            icon
                            large
                            target="_blank"
                            v-on="on"
                        >
                            <v-icon>mdi-code-tags</v-icon>
                        </v-btn>
                    </template>
                    <span>Source</span>
                </v-tooltip>
            </v-toolbar>
            <v-card-text>
                <v-form>
                    <v-text-field
                        label="register"
                        name="register"
                        prepend-icon="mdi-account"
                        type="text"
                    ></v-text-field>

                    <v-text-field
                        id="password"
                        label="Password"
                        name="password"
                        prepend-icon="mdi-lock"
                        type="password"
                    ></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary">Register</v-btn>
            </v-card-actions>
        </v-card>
    </v-col>
</template>

<script>
    export default {
        name: "RegisterForm"
    }
</script>
