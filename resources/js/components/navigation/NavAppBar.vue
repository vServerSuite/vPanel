<template>
    <v-app-bar app color="indigo" dark>
        <v-toolbar-title>vSuite</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon>
            <v-icon>mdi-account-circle</v-icon>
        </v-btn>
        <v-btn icon>
            <form action="/logout" method="POST">
                <v-btn  type="submit" text icon>
                    <v-icon>mdi-logout</v-icon>
                </v-btn>
            </form>
        </v-btn>
    </v-app-bar>
</template>
