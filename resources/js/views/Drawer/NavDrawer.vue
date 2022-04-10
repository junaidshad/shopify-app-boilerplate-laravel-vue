<template>
    <div>
        <v-navigation-drawer app permanent v-if="loggedIn">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h6">
                        Application
                    </v-list-item-title>
                    <v-list-item-subtitle>
                        subtext
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list
                dense
                nav
            >
                <v-list-item
                    v-for="item in items"
                    :key="item.title"
                    :to="item.link"
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "NavDrawer",
        data () {
            return {
                items: [
                    { title: 'Dashboard', icon: 'mdi-view-dashboard', link: '/' },
                    { title: 'Campaigns', icon: 'mdi-image', link: '/campaigns' },
                ],
                right: null,
            }
        },
        computed: {
            ...mapGetters('auth', ['loggedIn'])
        },
    }
</script>

<style scoped>

</style>
