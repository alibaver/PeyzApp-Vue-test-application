import Vue from "vue";
import Vuetify from "vuetify/lib";
import colors from "vuetify/lib/util/colors";
import "vuetify/dist/vuetify.min.css";
import "@mdi/font/css/materialdesignicons.css";
import lineClamp from "vue-line-clamp";

Vue.use(Vuetify);
Vue.use(lineClamp);

const opts = {
    theme: {
        themes: {
            light: {
                primary: colors.purple, // #E53935
                secondary: colors.red.lighten4, // #FFCDD2
                accent: colors.indigo.base // #3F51B5
            },
            dark: {
                primary: colors.red.darken1, // #E53935
                secondary: colors.red.lighten4, // #FFCDD2
                accent: colors.indigo.base // #3F51B5
            }
        }
    }
};

export default new Vuetify(opts);
