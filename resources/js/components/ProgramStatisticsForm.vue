<template>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <span class="h4 text-center">STATISTIKA</span>
        </div>
        <div class="card-body">
            <p>Molimo vas da odvojite malo vremena i da, dok čekate termin za potpis ugovora,
                popunite polja u formularu ispod. Ovi podaci nam znače za pregled statistike.
            </p>
            <hr/>
            <b-form class="w-100 mt-4">
                <div class="d-flex flex-wrap">
                    <b-form-group
                        label="Prihodi"
                        description="Iznos prihoda za proteklu godinu" class="attribute-label font-weight-bold mr-3">
                        <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                            <b-form-input v-model="form.iznosPrihoda" size="sm" type="text"></b-form-input>
                        </b-input-group>
                    </b-form-group>

                    <b-form-group
                        label="Izvoz"
                        description="Ukupna suma izvoza za proteklu godinu" class="attribute-label font-weight-bold mr-3">
                        <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                            <b-form-input v-model="form.iznosIzvoza" size="sm" type="text"></b-form-input>
                        </b-input-group>
                    </b-form-group>

                    <b-form-group
                        label="Porezi"
                        description="Iznos plaćenih poreza za proteklu godinu" class="attribute-label font-weight-bold mr-3">
                        <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                            <b-form-input v-model="form.iznosPlacenihPoreza" size="sm" type="text"></b-form-input>
                        </b-input-group>
                    </b-form-group>

                    <b-form-group
                        label="Ulaganja"
                        description="Ulaganje u istraživanje i razvoj (iznos)" class="attribute-label font-weight-bold mr-3">
                        <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                            <b-form-input v-model="form.iznosUlaganja" size="sm" type="text"></b-form-input>
                        </b-input-group>
                    </b-form-group>

                    <b-form-group
                        label="Zaposleni"
                        description="Broj svih zaposlenih" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                        <b-form-input v-model="form.brojZaposlenih" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
                    </b-form-group>

                    <b-form-group
                        label="Angažovani"
                        description="Broj svih angažovanih ljudi na projektu" class="attribute-label font-weight-bold mr-3" style="width: 100px">
                        <b-form-input v-model="form.brojAngazovanih" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
                    </b-form-group>
                </div>
                <h4 class="w-100 h4 mb-4 attribute-label">Broj zaštićenih patenata</h4>
                <div class="d-flex flex-wrap align-items-center justify-content-center">
                    <b-form-group
                        label="Mali patenti"
                        description="Broj zaštićenih malih patenata" class="attribute-label font-weight-bold mr-3">
                        <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                            <b-form-input v-model="form.brMalihPatenata" size="sm" type="text"></b-form-input>
                        </b-input-group>
                    </b-form-group>
                    <b-form-group
                        label="Patenti"
                        description="Broj zaštićenih patenata" class="attribute-label font-weight-bold mr-3">
                        <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                            <b-form-input v-model="form.brPatenata" size="sm" type="text"></b-form-input>
                        </b-input-group>
                    </b-form-group>
                    <b-form-group
                        label="Autorska dela"
                        description="Broj zaštićenih autorskih dela" class="attribute-label font-weight-bold mr-3">
                        <b-input-group append="RSD" size="sm" style="width: 200px" class="shadow-sm">
                            <b-form-input v-model="form.brAutorskihDela" size="sm" type="text"></b-form-input>
                        </b-input-group>
                    </b-form-group>
                </div>
                <div class="d-flex align-items-center justify-content-center mt-4">
                    <b-button type="button" size="sm" variant="primary" class="m-1">Prihvati</b-button>
                    <b-button type="button" size="sm" variant="outline-primary" class="m-1">Resetuj</b-button>
                </div>
            </b-form>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProgramStatisticsForm",
    props: {
        program_id: { typeof: Number, default: 0 }
    },
    methods: {
        async getData() {

        }
    },
    async mounted() {
        await this.getData();
    },
    data() {
        return {
            form: {
                id: 0,
                iznosPrihoda: 0.0,
                iznosIzvoza: 0.0,
                brojZaposlenih: 0,
                brojAngazovanih: 0,
                iznosPlacenihPoreza: 0.0,
                iznosUlaganja: 0.0,
                brMalihPatenata: 0,
                brPatenata: 0.0,
                brAutorskihDela: 0,
                brInovacija: 0,
                countries: []
            }
        }
    }
}
</script>

<style scoped>

</style>
