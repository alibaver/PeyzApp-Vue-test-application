<template>
    <div class="d-flex justify-content-center">
        <v-carousel
            width="100%"
            height="auto"
            cycle
            hide-delimiter-background
            hide-delimiters
            show-arrows-on-hover
            style="max-width:1320px"
        >
            <v-carousel-item v-for="(slide, i) in slides" :key="i">
                <v-sheet>
                    <v-row class="fill-height" align="center" justify="center">
                        <img :src="slide" width="100%" height="auto" />
                    </v-row>
                </v-sheet>
            </v-carousel-item>
        </v-carousel>
    </div>
</template>
<script>
export default {
    data() {
        return {
            slides: [
                "../../images/slider/1.jpg",
                "../../images/slider/2.jpg",
                "../../images/slider/3.jpg",
                "../../images/slider/4.jpg",
                "../../images/slider/5.jpg",
                "../../images/slider/6.jpg",
                "../../images/slider/7.jpg",
                "../../images/slider/8.jpg"
            ]
        };
    }
};
</script>
