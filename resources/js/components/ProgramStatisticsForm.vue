<template>
    <b-form v-if="editMode" class="w-100 mt-4">
        <h4 class="w-100 attribute-label text-center">OSNOVNA STATISTIKA</h4>
        <div class="d-flex flex-wrap justify-content-center border border-light shadow-sm p-2">
            <b-form-group
                label="Prihodi"
                description="Iznos prihoda za proteklu godinu" class="attribute-label font-weight-bold mr-3">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.iznos_prihoda" size="sm" type="number" min="0.0"  step="0.01" ></b-form-input>
                </b-input-group>
            </b-form-group>

            <b-form-group
                label="Izvoz"
                description="Ukupna suma izvoza za proteklu godinu" class="attribute-label font-weight-bold mr-3">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.iznos_izvoza" size="sm" type="number" min="0.0"  step="0.01"></b-form-input>
                </b-input-group>
            </b-form-group>

            <b-form-group
                label="Porezi"
                description="Iznos plaćenih poreza za proteklu godinu" class="attribute-label font-weight-bold mr-3">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.iznos_placenih_poreza" size="sm" type="number" min="0.0" step="0.01"></b-form-input>
                </b-input-group>
            </b-form-group>

            <b-form-group
                label="Faza razvoja"
                description="U kojoj se fazi razvoja nalazite" class="attribute-label font-weight-bold mr-3" >
                <b-form-select v-model="form.faza_razvoja" :options="faze_razvoja" size="sm" style="width: 150px"></b-form-select>
            </b-form-group>

            <b-form-group
                label="Ulaganja"
                description="Ulaganje u istraživanje i razvoj (iznos)" class="attribute-label font-weight-bold mr-3">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.iznos_ulaganja_istrazivanje_razvoj" size="sm" type="number" min="0.0" step="0.01"></b-form-input>
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
                <table class="table table-sm table-bordered font-11 shadow-sm">
                    <tr>
                        <td colspan="2">Iznos prihoda za proteklu godinu</td>
                        <td class="font-weight-bold text-right attribute-label">{{ formatter.format(form.iznos_prihoda) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Ukupna suma izvoza za proteklu godinu</td>
                        <td class="font-weight-bold text-right attribute-label">{{ formatter.format(form.iznos_izvoza)  }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Iznos plaćenih poreza za proteklu godinu</td>
                        <td class="font-weight-bold text-right attribute-label">{{ formatter.format(form.iznos_placenih_poreza) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Ulaganje u istraživanje i razvoj (iznos)</td>
                        <td class="font-weight-bold text-right attribute-label">{{ formatter.format(form.iznos_ulaganja_istrazivanje_razvoj) }}</td>
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
                        <td colspan="2">Faza razvoja</td>
                        <td class="font-weight-bold text-right attribute-label">{{ fazaRazvojaTekst }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Broj inovacija koje razvijate</td>
                        <td class="font-weight-bold text-right attribute-label">{{ form.broj_inovacija }}</td>
                    </tr>
                    <tr>
                        <td rowspan="3" style="position: relative">
                            <div class="d-flex align-items-center" style="height: 100px">
                                BROJ ZAŠTIĆENIH PATENATA
                            </div>
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
        profile_id: { typeof: Number, default: 0 }
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
        },
        fazaRazvojaTekst() {
            return this.faze_razvoja[this.form.faza_razvoja].text;
        }
    },
    methods: {
        numberFormatter(value) {
            return this.formatter.format(value);
        },
        async getData() {
            await axios.get('/profiles/statistics/' + this.profile_id)
            .then(response => {
                this.form = response.data;
                this.form.id = this.profile_id;
                if(this.countries == null) {
                    this.countries = [];
                }
                this.statistic_sent = response.data.statistic_sent;

            });
        },
        async getCountries() {
            let formData = new FormData();
            if(Array.isArray(this.form.countries)) {
                this.form.countries.forEach(id => {
                    formData.append('ids[]', id);
                });
                await axios.post('/analytics/countryNames', formData)
                    .then(response => {
                        this.countryNames = response.data;
                    });
            }
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
                    if(Array.isArray(this.form.countries)) {
                        this.form.countries.forEach(country => {
                            formData.append('countries[]', country);
                        });
                    }

                }
            }

            await axios.post('/profiles/statistics', formData)
            .then(response => {
                console.log(response.data);
            });

            this.editMode = false;
            await this.getData();
            await this.getCountries();
        }
    },
    async mounted() {
        this.formatter = new Intl.NumberFormat('sr-RS',
            {
                style: 'currency',
                currency: 'RSD'
            });

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
                faza_razvoja: 0,
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
            },
            faze_razvoja: [
                { value: 0, text: "Izaberite ..."},
                { value: 1, text: 'Ideja'},
                { value: 2, text: 'Pre-product (PoC), pre-revenue'},
                { value: 3, text: 'Alpha/Prototype 1'},
                { value: 4, text: 'Beta/Prototype 2'},
                { value: 5, text: 'MVP'},
                { value: 6, text: 'Revenue'}
            ],
            formatter: null
        }
    }
}
</script>

<style scoped>

</style>
