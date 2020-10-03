<template>
    <div>
        <v-breadcrumbs :items="pagePath" class="pa-0 mb-3 secondary--text">
            <template v-slot:divider>
                <v-icon>mdi-chevron-right</v-icon>
            </template>
        </v-breadcrumbs>
    </div>
</template>
<script>
export default {
    data: () => ({
        pagePath: [{ text: "Anasayfa", disabled: false, to: "/" }]
    }),
    created() {
        let pname = this.$route.name;
        let ppath = this.$route.fullPath;
        //console.log(ppath.split("/"));
        this.pagePath.push({
            text: pname,
            disabled: true,
            to: ppath
        });
        //console.log(this.pagePath);
    }
};
</script>
