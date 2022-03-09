<template>
    <b-form v-if="editMode" class="w-100 mt-4">
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

        <countries-selector v-model="form.countries" class="m-2 border border-light shadow-sm p-2"></countries-selector>
        <hr/>
        <div class="d-flex align-items-center justify-content-center mt-4">
            <b-button type="button" size="sm" variant="primary" class="m-1" @click="onSubmit">Prihvati izmene</b-button>
            <b-button type="button" size="sm" variant="outline-primary" class="m-1" @click="closeForm">Zatvori formu</b-button>
        </div>
    </b-form>
    <div v-else>
        <div v-if="!statistic_sent" class="p-2 m-0">
            <p class="text-center attribute-label font-weight-bold">MOLBA</p>
            <p class="font-11 text-center">Molimo Vas da, dok čekate datum sastanka, u međuvremenu popunite podatke koji su nam neophodni za statistiku.</p>
            <div class="d-flex align-items-center justify-content-center">
                <b-button size="sm" type="button" variant="primary" @click="openForm">Dodaj statistiku</b-button>
            </div>
        </div>
        <div v-else class="p-2">
            <h4 class="attribute-label text-center">STATISTIKA</h4>
            <div class="d-flex flex-column align-items-center justify-content-center">
                <table class="table table-sm table-bordered font-11">
                    <tr>
                        <td colspan="2">Iznos prihoda za proteklu godinu</td>
                        <td class="font-weight-bold text-right attribute-label">{{ form.iznos_prihoda }} RSD</td>
                    </tr>
                    <tr>
                        <td colspan="2">Ukupna suma izvoza za proteklu godinu</td>
                        <td class="font-weight-bold text-right attribute-label">{{ form.iznos_izvoza }} RSD</td>
                    </tr>
                    <tr>
                        <td colspan="2">Iznos plaćenih poreza za proteklu godinu</td>
                        <td class="font-weight-bold text-right attribute-label">{{ form.iznos_placenih_poreza }} RSD</td>
                    </tr>
                    <tr>
                        <td colspan="2">Ulaganje u istraživanje i razvoj (iznos)</td>
                        <td class="font-weight-bold text-right attribute-label">{{ form.iznos_ulaganja_istrazivanje_razvoj }} RSD</td>
                    </tr>
                    <tr>
                        <td colspan="2">Broj svih zaposlenih</td>
                        <td class="font-weight-bold text-right attribute-label">{{ form.broj_zaposlenih }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Broj svih angažovanih ljudi na projektu</td>
                        <td class="font-weight-bold text-right attribute-label">{{ form.broj_angazovanih }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Od toga žene</td>
                        <td class="font-weight-bold text-right attribute-label">{{ form.broj_angazovanih_zena }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Broj inovacija koje razvijate</td>
                        <td class="font-weight-bold text-right attribute-label">{{ form.broj_inovacija }}</td>
                    </tr>
                    <tr>
                        <td rowspan="3" class="align-items-center">
                            BROJ ZAŠTIĆENIH PATENATA
                        </td>
                        <td>Broj malih patenata</td>
                        <td class="text-right attribute-label font-weight-bold">{{ form.broj_malih_patenata }}</td>
                    </tr>
                    <tr>
                        <td>Broj patenata</td>
                        <td class="text-right attribute-label font-weight-bold">{{ form.broj_patenata }}</td>
                    </tr>
                    <tr>
                        <td>Broj autorskih dela</td>
                        <td class="text-right attribute-label font-weight-bold">{{ form.broj_autorskih_dela }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Zemlje u koje ste izvozili</td>
                        <td class="text-right attribute-label font-weight-bold">{{ this.selectedCountryNames }}</td>
                    </tr>

                </table>
                <b-button type="button" size="sm" variant="primary" @click="openForm" class="mt-2">Promeni</b-button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProgramStatisticsForm",
    props: {
        program_id: { typeof: Number, default: 0 }
    },
    computed: {
        selectedCountryNames() {
            let countryNames = '';
            if(this.countryNames.length > 0) {
                this.countryNames.forEach(name => {
                    if(countryNames.length > 0) {
                        countryNames += ', ';
                    }
                    countryNames += name;
                });
            }

            return countryNames;
        }
    },
    methods: {
        async getData() {
            await axios.get('/programs/statistics/' + this.program_id)
            .then(response => {
                this.form = response.data;
                this.form.id = this.program_id;
                this.statistic_sent = response.data.statistic_sent;
            });
        },
        async getCountries() {
            let formData = new FormData();
            this.form.countries.forEach(id => {
                formData.append('ids[]', id);
            });
            await axios.post('/analytics/countryNames', formData)
            .then(response => {
                this.countryNames = response.data;
            });
        },
        openForm() {
            this.editMode = true;
        },
        closeForm() {
            this.editMode = false;
        },
        async onSubmit() {
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
                    if(key === 'statistic_sent') {
                        let strValue = '';
                        if(value)
                            strValue = 'on';
                        else
                            strValue = 'off';

                        formData.append(key, strValue);
                    } else {
                        formData.append(key, value.toString());
                    }

                }  else {
                    this.form.countries.forEach(country => {
                        formData.append('countries[]', country);
                    });
                }
            }

            await axios.post('/programs/statistics', formData)
            .then(response => {
                console.log(response.data);
            });

            this.editMode = false;
            await this.getData();
            await this.getCountries();
        }
    },
    async mounted() {
        await this.getData();
        await this.getCountries();
    },
    data() {
        return {
            editMode: false,
            countryNames: [],
            statistic_sent: false,
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
                countries: [],
            }
        }
    }
}
</script>

<style scoped>

</style>
