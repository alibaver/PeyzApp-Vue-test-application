<template>
    <v-card>
        <v-list subheader two-line>
            <v-subheader class="d-inline-flex">
                <v-icon small class="pr-2">mdi-bell</v-icon
                >DUYURULAR</v-subheader
            >
            <v-btn small text class="m-2 float-right">TÜMÜ</v-btn>
            <v-list-item
                class="text-wrap text-center"
                v-for="(item, index) in notifyCard"
                :key="index"
                link
            >
                <v-list-item-action
                    class="d-flex justify-content-center align-items-center m-0 overline"
                >
                    <v-icon small>mdi-calendar</v-icon>
                    {{ item.date }}
                </v-list-item-action>
                <v-list-item-content class="text-left pl-4">
                    <v-list-item-subtitle class=" text-wrap">
                        {{ item.title }}
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-card>
</template>
<script>
export default {
    props: {
        notifyCard: {
            type: Array,
            required: true
        }
    },
    data: () => ({}),
    mounted() {}
};
</script>
