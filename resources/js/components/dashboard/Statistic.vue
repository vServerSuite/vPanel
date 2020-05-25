<template>
    <v-card class="mt-4">
        <v-sheet
            class="v-sheet--offset mx-auto"
            :color="color"
            elevation="6"
            max-width="calc(100% - 32px)"
        >
            <v-sparkline
                :labels="labels"
                :value="value"
                color="white"
                line-width="2"
                padding="16"
            ></v-sparkline>
        </v-sheet>

        <v-card-text class="pt-0">
            <div class="title font-weight-light mb-2">
                {{ title }}: <slot></slot>
            </div>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: "Statistic",
    props: ["title", "color"],
    data: () => ({
        labels: ["12am", "3am", "6am", "9am", "12pm", "3pm", "6pm", "9pm"],
        value: [200, 675, 410, 390, 310, 460, 250, 240]
    })
};
</script>
