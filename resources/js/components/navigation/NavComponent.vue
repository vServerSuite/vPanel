<template>
    <div>
        <NavDrawer></NavDrawer>
        <NavAppBar></NavAppBar>
    </div>
</template>
<script>
    import NavAppBar from './NavAppBar.vue';
    import NavDrawer from './NavDrawer.vue';

    export default {
        components: {
            NavAppBar,
            NavDrawer
        }
    };
</script>
