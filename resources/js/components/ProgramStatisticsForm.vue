<template>
    <b-form class="w-100 mt-4">
        <h4 class="w-100 attribute-label text-center">OSNOVNA STATISTIKA</h4>
        <div class="d-flex flex-wrap justify-content-center border border-light shadow-sm p-2">
            <b-form-group
                label="Prihodi"
                description="Iznos prihoda za proteklu godinu" class="attribute-label font-weight-bold mr-3">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.iznos_prihoda" size="sm" type="text"></b-form-input>
                </b-input-group>
            </b-form-group>

            <b-form-group
                label="Izvoz"
                description="Ukupna suma izvoza za proteklu godinu" class="attribute-label font-weight-bold mr-3">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.iznos_izvoza" size="sm" type="text"></b-form-input>
                </b-input-group>
            </b-form-group>

            <b-form-group
                label="Porezi"
                description="Iznos plaćenih poreza za proteklu godinu" class="attribute-label font-weight-bold mr-3">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.iznos_placenih_poreza" size="sm" type="text"></b-form-input>
                </b-input-group>
            </b-form-group>

            <b-form-group
                label="Ulaganja"
                description="Ulaganje u istraživanje i razvoj (iznos)" class="attribute-label font-weight-bold mr-3">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.iznos_ulaganja_istrazivanje_razvoj" size="sm" type="text"></b-form-input>
                </b-input-group>
            </b-form-group>

            <b-form-group
                label="Zaposleni"
                description="Broj svih zaposlenih" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.broj_zaposlenih" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>

            <b-form-group
                label="Angažovani"
                description="Broj svih angažovanih ljudi na projektu" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.broj_angazovanih" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>

            <b-form-group
                label="Žene"
                description="Broj angažovanih žena projektu" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.broj_angazovanih_zena" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>
            <b-form-group
                label="Inovacije"
                description="Broj inovacija koje razvijate" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.broj_inovacija" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>
        </div>
        <h4 class="w-100 attribute-label text-center mt-4">BROJ ZAŠTIĆENIH PATENATA</h4>

        <div class="d-flex flex-wrap justify-content-center border border-light shadow-sm p-2">
            <b-form-group
                label="Mali patenti"
                description="Broj zaštićenih malih patenata" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.broj_malih_patenata" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>
            <b-form-group
                label="Patenti"
                description="Broj zaštićenih patenata" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.broj_patenata" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>
            <b-form-group
                label="Autorska dela"
                description="Broj zaštićenih autorskih dela" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.broj_autorskih_dela" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>
        </div>
        <h4 class="w-100 h4 attribute-label text-center mt-4">SPISAK ZEMALJA U KOJE IZVOZITE</h4>

        <countries-selector v-model="form.countries" class="mt-2 mb-4 border border-light shadow-sm p-2"></countries-selector>
        <hr/>
        <div class="d-flex align-items-center justify-content-center mt-4">
            <b-button type="button" size="sm" variant="primary" class="m-1" @click="onSubmit">Prihvati</b-button>
            <b-button type="button" size="sm" variant="outline-primary" class="m-1">Resetuj</b-button>
        </div>
    </b-form>
</template>

<script>
export default {
    name: "ProgramStatisticsForm",
    props: {
        program_id: { typeof: Number, default: 0 }
    },
    methods: {
        async getData() {
            await axios.get('/programs/statistics/' + this.program_id)
            .then(response => {
                this.form = response.data;
            });
        },
        onSubmit() {
            let formData = new FormData();

            // for(const property in this.form) {
            //     if(property != 'countries')
            //         data.append(property, this.form[property]);
            //     else {
            //
            //     }
            //
            // }

            for(const[key, value] of Object.entries(this.form)) {
                if(key != 'countries') {
                    formData.append(key, value.toString());
                } else {
                    this.form.countries.forEach(country => {
                        formData.append('countries[]', country);
                    });
                }
            }

            axios.post('/programs/statistics', formData)
            .then(response => {
                console.log(response.data);
            });
        }
    },
    async mounted() {
        await this.getData();
        this.form.id = this.program_id;
    },
    data() {
        return {
            form: {
                id: 0,
                iznos_prihoda: 0.0,
                iznos_izvoza: 0.0,
                broj_zaposlenih: 0,
                broj_angazovanih: 0,
                broj_angazovanih_zena: 0,
                iznos_placenih_poreza: 0.0,
                iznos_ulaganja_istrazivanje_razvoj: 0.0,
                broj_malih_patenata: 0,
                broj_patenata: 0.0,
                broj_autorskih_dela: 0,
                broj_inovacija: 0,
                countries: []
            }
        }
    }
}
</script>

<style scoped>

</style>
