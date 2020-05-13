<template>
    <v-card color="primary" v-if="visible" dark>
        <div class="d-flex flex-no-wrap justify-space-between">
            <div>
                <v-card-title class="headline">{{ title }}</v-card-title>
            </div>

            <v-avatar class="ma-3" size="128" tile>
                <v-img
                    :src="imgUrl"
                    :alt="`${title}`"
                ></v-img>
            </v-avatar>
        </div>
    </v-card>
</template>
<script>
export default {
    name: "OnboardingCard",
    props: {
        visible: false,
        title: null,
        imgUrl: null
    }
}
</script>