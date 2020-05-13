<template>
    <v-timeline :dense="true">
        <v-timeline-item v-for="donation in donations" :key="donation">
            <template v-slot:icon>
                <v-avatar>
                    <v-img :src="'https://crafatar.com/avatars/' + donation.uuid + '.png'" />
                </v-avatar>
            </template>
            <v-card class="elevation-2">
            <v-card-title class="headline">{{ donation.name }}</v-card-title>
            <v-card-text>{{ donation.package_type }}</v-card-text>
            </v-card>
        </v-timeline-item>
    </v-timeline>
</template>

<script>
export default {
    name: 'Donations',
    data: () => ({
      donations: [
        {
            id: 1,
            name: 'Monkeeeh',
            package_type: 'Donator 1',
            uuid: '17a87d89-e098-436c-93e1-da0b4dfc2b98'
        },
        {
            id: 2,
            name: 'Ben________',
            package_type: 'Donator 2',
            uuid: '9747283c-5814-4c14-947e-a0dbb13ced3a'
        },
        {
            id: 3,
            name: 'Ben________',
            package_type: 'Donator 2',
            uuid: '9747283c-5814-4c14-947e-a0dbb13ced3a'
        }
      ]
    }),
}
</script>