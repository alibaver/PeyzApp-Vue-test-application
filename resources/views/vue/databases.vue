<template>
    <div>
        <v-row>
            <!-- <div class="col-12 col-sm-7">
        <v-card>datatables</v-card>
      </div>-->
            <v-col cols="12" sm="7">
                <data-table
                    :table-title="'Veritabanları (A-Z)'"
                    :data-headers="headers"
                    :data-items="dataItems"
                    :table-options="tableOpt"
                    :data-filter="true"
                    :subject-type="subItems"
                    :database-type="databaseTypeItems"
                    :vendors-type="vendorsItems"
                ></data-table>
            </v-col>
            <v-col cols="12" sm="5">
                <data-table
                    :table-title="'Yeni / Deneme Veritabanları'"
                    :data-headers="headers"
                    :data-items="trialDataItems"
                    :table-options="tableOpt"
                    :data-filter="false"
                ></data-table>
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    data() {
        return {
            subItems: ["Tüm Konular", "Bar", "Fizz", "Buzz"],
            databaseTypeItems: ["Tüm Veritabanları", "Bar", "Fizz", "Buzz"],
            vendorsItems: ["Tüm Dağıtıcılar", "Bar", "Fizz", "Buzz"],
            tableOpt: {
                footerProps: {
                    itemsPerPageText: "Satır sayısı:",
                },
                sortBy: "name",
                sortDesc: false,
            },
            headers: [
                {
                    text: "Veritabanı Adı",
                    align: "start",
                    value: "name",
                },
                { text: "Link", align: "end", value: "path", sortable: false },
            ],
            dataItems: [
                {
                    name: "ASTM Standards and Engineering Digital Library",
                    path: "/databases",
                },
                {
                    name: "Bibliyometrik Atıf Veritabanı – Scopus / (EKUAL)",
                    path: "/databases",
                },
                {
                    name:
                        "Bibliyometrik Atıf Veritabanı - Web of Science / (EKUAL)",
                    path: "/databases",
                },
                {
                    name: "EBSCO Academic Search Ultimate / (EKUAL)",
                    path: "/databases",
                },
                {
                    name:
                        "EBSCO Applied Science & Business Periodicals Retrospective Index / (EKUAL)",
                    path: "/databases",
                },
                {
                    name:
                        "ProQuest Dissertations & Theses Global (Tez Veritabanı) / (EKUAL)",
                    path: "/databases",
                },
                {
                    name: "IEEE Digital Library / (EKUAL)",
                    path: "/databases",
                },
                {
                    name: "JSTOR Archive Journal Content / (EKUAL)",
                    path: "/databases",
                },
                {
                    name: "Springer Nature – Academic Journals / (EKUAL)",
                    path: "/databases",
                },
                {
                    name: "Taylor & Francis / (EKUAL)",
                    path: "/databases",
                },
                {
                    name: "Wiley Online Library / (EKUAL)",
                    path: "/databases",
                },
            ],
            trialDataItems: [
                {
                    name: "İdealonline",
                    path: "/databases",
                },
                {
                    name: "Total Materia",
                    path: "/databases",
                },
                {
                    name: "Turcademy",
                    path: "/databases",
                },
                {
                    name: "IEEE e-Learning Library",
                    path: "/databases",
                },
            ],
        };
    },
};
</script>

<style></style>
