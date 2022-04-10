<template>
    <div>
        <v-row class="align-center justify-center text-capitalize">
            welcome to the king of iron fist.
            <!--<v-col cols="12" sm="12" class="text-center">
                Create your first Campaign
            </v-col>
            <v-col cols="12">
                <v-text-field v-model="campaignName" outlined flat hide-details dense placeholder="Campaign Name"></v-text-field>
            </v-col>
            <v-col cols="12" sm="12">
                <v-btn outlined dense text @click="createCampaign">Create</v-btn>
            </v-col>-->
        </v-row>
    </div>
</template>

<script>
    export default {
        name: "Home",
        data () {
            return {
                campaignName: '',
                loading: false,
                campaigns: null
            }
        },
        created() {

        },
        methods: {
            createCampaign () {
                let self = this;
                console.log("Method::createCampaign ~ campaign_name -> ", this.campaignName);
                axios.post('/api/campaign/create', {campaignName: this.campaignName})
                .then(resp => {
                    if(resp.data.status === true) {
                        // re-route to the RSS Config page.
                        self.$router.push({name: 'rss', params: {campaignId: resp.data.campaign.id, campaignName: resp.data.campaign.name}});
                    }
                })
                .catch(err => {
                    console.log("METHOD::API ~ err -> ", err);
                })
            },

        }
    }
</script>

<style scoped>

</style>
