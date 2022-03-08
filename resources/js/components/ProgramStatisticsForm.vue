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
                    <div class="d-flex align-items-center mr-3">
                        <span class="mr-2 attribute-label font-weight-bold">Prihodi</span>
                        <b-input-group append="RSD" size="sm" style="width: 200px"  class="shadow-sm">
                            <b-form-input v-model="form.iznosPrihoda" size="sm" type="text" ></b-form-input>
                        </b-input-group>
                    </div>

                    <div class="d-flex align-items-center mr-3">
                        <span class="mr-2 attribute-label font-weight-bold">Izvoz</span>
                        <b-input-group append="RSD" style="width: 200px" class="shadow-sm" size="sm">
                            <b-form-input v-model="form.iznosIzvoza" size="sm" type="text"></b-form-input>
                        </b-input-group>
                    </div>
                    <div class="d-flex align-items-center mr-3">
                        <span class="mr-2 attribute-label font-weight-bold">Broj zaposlenih</span>
                        <b-form-input v-model="form.brojZaposlenih" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
                    </div>
                    <div class="d-flex align-items-center mr-3">
                        <span class="mr-2 attribute-label font-weight-bold">Broj angažovanih</span>
                        <b-form-input v-model="form.brojAngazovanih" size="sm" type="number" style="width: 80px" class="shadow-sm"></b-form-input>
                    </div>
                    <div class="d-flex align-items-center mr-3">
                        <span class="mr-2 attribute-label font-weight-bold">Plaćeni </span>
                        <b-input-group append="RSD" style="width: 200px" class="shadow-sm" size="sm">
                            <b-form-input v-model="form.iznosIzvoza" size="sm" type="text"></b-form-input>
                        </b-input-group>
                    </div>
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
