<template>
    <b-form v-if="editMode" class="w-100 mt-4">
        <div v-if="header" class="p-2 m-0">
            <p class="text-center attribute-label font-weight-bold">VAŽNO</p>
            <p class="font-11 text-center">Kako biste otpočeli Fazu 2 potrebno je da unesete sve podatke ispod:</p>
            <div class="d-flex align-items-center justify-content-center">
                <b-button size="sm" type="button" variant="primary" @click="openForm">Dodaj statistiku</b-button>
            </div>
        </div>
        <h4 class="w-100 attribute-label text-center">POSLOVNI PODACI</h4>
        <div class="d-flex flex-wrap justify-content-center border border-light shadow-sm p-2">
            <b-form-group
                label="Prihodi"
                description="Iznos ostvarenih prihoda za proteklu godinu" class="attribute-label font-weight-bold mr-3"
                style="max-width: 200px">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm" >
                    <b-form-input v-model="form.iznos_prihoda" size="sm" type="number" min="0.0"  step="0.01" ></b-form-input>
                </b-input-group>
            </b-form-group>

            <b-form-group
                label="Izvoz"
                description="Iznos ostvarenih prihoda u prethodnoj godini koji je ostvaren na stranim tržištima"
                class="attribute-label font-weight-bold mr-3"
                style="max-width: 200px">
                <b-input-group append="RSD" size="sm" style="width: 200px; max-width: 300px" class="shadow-sm">
                    <b-form-input v-model="form.iznos_izvoza" size="sm" type="number" min="0.0"  step="0.01"></b-form-input>
                </b-input-group>
            </b-form-group>

            <b-form-group
                label="Porezi i doprinosi"
                description="Iznos plaćenih poreza i doprinosa u prethodnoj godini"
                class="attribute-label font-weight-bold mr-3"
                style="max-width: 200px">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.iznos_placenih_poreza" size="sm" type="number" min="0.0" step="0.01"></b-form-input>
                </b-input-group>
            </b-form-group>

            <b-form-group
                label="Faza razvoja"
                description="U kojoj se fazi razvoja nalazite"
                class="attribute-label font-weight-bold mr-3"
                style="max-width: 200px">
                <b-form-select v-model="form.faza_razvoja" :options="faze_razvoja" size="sm" style="width: 200px"></b-form-select>
            </b-form-group>

            <b-form-group
                label="Ulaganja"
                description="Ulaganje u istraživanje i razvoj (iznos)"
                class="attribute-label font-weight-bold mr-3"
                style="max-width: 200px">
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
                description="Broj ukupno angažovanih" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.broj_angazovanih" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>

            <b-form-group
                label="Žene"
                description="Broj ukupno angažovanih žena u timu" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.broj_angazovanih_zena" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>
            <b-form-group
                label="Žene osnivači"
                description="Broj žena u osnivačkoj strukturi" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.women_founders_count" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>
            <b-form-group
                label="Inovacije"
                description="Broj inovacija koje razvijate" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.broj_inovacija" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>
            <b-form-group
                label="Povratnici iz inostranstva"
                description="Broj zaposlenih koji su više od 24 meseca pretežno boravili u inostranstvu" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.broj_povratnika_iz_inostranstva" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>

        </div>
        <h4 class="w-100 attribute-label text-center mt-4">IZNOS INVESTICIJA PO KATEGORIJAMA</h4>
        <div class="d-flex flex-wrap justify-content-center border border-light shadow-sm p-2">
            <b-form-group
                label="VC Fond"
                description="Iznos investicija - VC Fond" class="attribute-label font-weight-bold mr-3" style="max-width: 200px">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.investicije_vc_fond" size="sm" type="number" min="0.0" step="0.01"></b-form-input>
                </b-input-group>
            </b-form-group>
            <b-form-group
                label="Angels Investors"
                description="Iznos investicija - Angels Investors" class="attribute-label font-weight-bold mr-3" style="max-width: 200px">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.investicije_angels_investors" size="sm" type="number" min="0.0" step="0.01"></b-form-input>
                </b-input-group>
            </b-form-group>
            <b-form-group
                label="Grant"
                description="Iznos investicija - Grant" class="attribute-label font-weight-bold mr-3" style="max-width: 200px">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.investicije_grant" size="sm" type="number" min="0.0" step="0.01"></b-form-input>
                </b-input-group>
            </b-form-group>
            <b-form-group
                label="3F"
                description="Iznos investicija - 3F" class="attribute-label font-weight-bold mr-3" style="max-width: 200px">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.investicije_3f" size="sm" type="number" min="0.0" step="0.01"></b-form-input>
                </b-input-group>
            </b-form-group>
            <b-form-group
                label="Drugo"
                description="Iznos investicija - Drugo" class="attribute-label font-weight-bold mr-3" style="max-width: 200px">
                <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                    <b-form-input v-model="form.investicije_other" size="sm" type="number" min="0.0" step="0.01"></b-form-input>
                </b-input-group>
            </b-form-group>
        </div>

        <h4 class="w-100 attribute-label text-center mt-4">BROJ ZAŠTIĆENIH PRAVA INTELEKTUALNE SVOJINE</h4>

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
            <b-form-group
                label="Zaštićen žig (logo)"
                description="Broj zaštićenih žigova" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                <b-form-input v-model="form.broj_zasticenih_zigova" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
            </b-form-group>
        </div>
        <h4 class="w-100 h4 attribute-label text-center mt-4">SPISAK ZEMALJA U KOJE IZVOZITE</h4>

        <countries-selector v-model="form.countries" class="m-2 border border-light shadow-sm p-2"></countries-selector>
        <hr/>
        <div class="d-flex align-items-center justify-content-center mt-4">
            <b-button type="button" size="sm" variant="primary" class="m-1" @click="onSubmit">Prihvati izmene</b-button>
            <b-button v-if="statistic_sent" type="button" size="sm" variant="outline-primary" class="m-1" @click="closeForm">Zatvori formu</b-button>
        </div>
    </b-form>
    <div v-else>
        <div class="p-2">
            <h4 class="attribute-label text-center">POSLOVNI PODACI KOMPANIJE</h4>
            <div class="d-flex flex-column align-items-center justify-content-center">
                <table class="table table-sm table-bordered font-11 shadow-sm">
                    <tr>
                        <td colspan="2">Iznos ostvarenih prihoda za proteklu godinu</td>
                        <td class="font-weight-bold text-right attribute-label">{{ formatter.format(form.iznos_prihoda) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Iznos ostvarenih prihoda u prethodnoj godini koji je ostvaren na stranim tržištima</td>
                        <td class="font-weight-bold text-right attribute-label">{{ formatter.format(form.iznos_izvoza)  }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Iznos plaćenih poreza i doprinosa u prethodnoj godini</td>
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
                        <td colspan="2">Broj ukupno angažovanih</td>
                        <td class="font-weight-bold text-right attribute-label">{{ form.broj_angazovanih }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Broj ukupno angažovanih žena u timu</td>
                        <td class="font-weight-bold text-right attribute-label">{{ form.broj_angazovanih_zena }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Broj žena u osnivačkoj strukturi</td>
                        <td class="font-weight-bold text-right attribute-label">{{ form.women_founders_count }}</td>
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
                        <td rowspan="5">
                            <div class="d-flex align-items-center justify-content-left" style="height: 150px">
                                IZNOS INVESTICIJA PO KATEGORIJAMA
                            </div>
                        </td>
                        <td>Investicije VC Fond</td>
                        <td class="text-right attribute-label font-weight-bold">{{ formatter.format(form.investicije_vc_fond) }}</td>
                    </tr>
                    <tr>
                        <td>Investicije - Angels Investors</td>
                        <td class="text-right attribute-label font-weight-bold">{{ formatter.format(form.investicije_angels_investors) }}</td>
                    </tr>
                    <tr>
                        <td>Investicije - Grant</td>
                        <td class="text-right attribute-label font-weight-bold">{{ formatter.format(form.investicije_grant) }}</td>
                    </tr>
                    <tr>
                        <td>Investicije - 3F</td>
                        <td class="text-right attribute-label font-weight-bold">{{ formatter.format(form.investicije_3f) }}</td>
                    </tr>
                    <tr>
                        <td>Investicije - Ostalo</td>
                        <td class="text-right attribute-label font-weight-bold">{{ formatter.format(form.investicije_other) }}</td>
                    </tr>

                    <tr>
                        <td rowspan="4" style="position: relative">
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
                        <td>Broj zaštićenih žigova</td>
                        <td class="text-right attribute-label font-weight-bold">{{ form.broj_zasticenih_zigova }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Broj zaposlenih koji su više od 24 meseca pretežno boravili u inostranstvu</td>
                        <td class="text-right attribute-label font-weight-bold">{{ form.broj_povratnika_iz_inostranstva }}</td>
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
        profile_id: { typeof: Number, default: 0 },
        header: { typeof: Boolean, default: false },
        test: { typeof: Number, default: 0 }
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
                console.log('statistika ...');
                console.log(response.data);
                // this.form = response.data;
                for(let property in response.data) {
                    if(response.data[property] != null)
                    {
                        this.form[property] = response.data[property];
                    }
                }
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

        if(!this.statistic_sent) {
            this.editMode = true;
        }


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
                women_founders_count: 0,
                broj_zasticenih_zigova: 0,
                broj_povratnika_iz_inostranstva: 0,
                investicije_vc_fond: 0.0,
                investicije_angels_investors: 0.0,
                investicije_grant: 0.0,
                investicije_3f: 0.0,
                investicije_other: 0.0
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
