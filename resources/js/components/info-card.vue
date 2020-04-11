<template>
    <v-card>
        <v-card-text>
            <v-icon small>{{ infoCard.icon }}</v-icon>
            <span class="caption">{{ infoCard.category }}</span>
            <div class="mt-2">{{ infoCard.date }}</div>
            <p class="title text--primary">
                {{ infoCard.title }}
            </p>
            <p v-line-clamp:20="5">
                {{ infoCard.content }}
            </p>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text color="footerLight pl-4">
                Devamı
                <v-icon small right>mdi-chevron-right</v-icon>
            </v-btn>
        </v-card-actions>
    </v-card>
</template>
<script>
export default {
    props: {
        infoCard: {
            type: Object,
            required: true
        }
    },
    data: () => ({}),
    mounted() {}
};
</script>
