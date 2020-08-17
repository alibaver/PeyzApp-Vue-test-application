<template>
    <v-sheet
        elevation="0"
        class="pa-0 mt-5"
        style="background-color:transparent"
    >
        <div class="justify-content-center align-items-center d-flex w100">
            <v-icon class="pr-2">mdi-trophy-award</v-icon>
            <span class="text-body-1">
                AYIN SEÇKİLERİ -
                <span class>{{ month }}</span>
            </span>
        </div>
        <v-slide-group
            :show-arrows="$vuetify.breakpoint.name == 'xs' ? false : true"
            center-active
            mandatory
            class="mt-3"
        >
            <v-slide-item
                v-for="(item, index) in monthlyAward"
                :key="index"
                v-slot:default="{ toggle }"
            >
                <v-card
                    width="285"
                    class="ma-4 removeShadow"
                    @click="toggle"
                    :ripple="false"
                >
                    <div class="d-flex flex-no-wrap justify-space-between">
                        <div>
                            <v-card-title class="text-subtitle-1">{{
                                item.type
                            }}</v-card-title>
                            <v-card-subtitle class="caption pb-1">{{
                                item.author
                            }}</v-card-subtitle>
                            <v-card-text class="caption pr-0">{{
                                item.content
                            }}</v-card-text>
                        </div>
                        <v-avatar size="140" tile class="my-3">
                            <v-img contain :src="item.img"></v-img>
                        </v-avatar>
                    </div>
                </v-card>
            </v-slide-item>
        </v-slide-group>
    </v-sheet>
</template>

<script>
export default {
    props: {
        monthlyAward: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        month: ""
    }),
    mounted() {
        this.month =
            new Date()
                .toLocaleString("tr", {
                    month: "long"
                })
                .toUpperCase() +
            " " +
            new Date().getFullYear();
    }
};
</script>
