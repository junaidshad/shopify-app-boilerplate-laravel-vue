<template>
    <v-app id="app">
        <nav-drawer></nav-drawer>
        <v-main>
            <v-container fluid>
                <transition name="fade" mode="out-in">
                    <RouterView :key="$route.fullPath"></RouterView>
                </transition>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
    import {mapGetters} from "vuex";
    import NavDrawer from "./Drawer/NavDrawer";

    export default {
        name: "App",
        components: {NavDrawer},
        data () {
            return {

            }
        },
        computed: {
            ...mapGetters('auth', ['loggedIn'])
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>
