<template>
<!--    <div class="shadow d-flex flex-column" style="width: 100px; height: 100px">-->
<!--        <div class="d-flex align-items-center justify-content-center" style="height: 50%">-->
<!--            <h3>.{{ extension }}</h3>-->
<!--        </div>-->
<!--        <div class="bg-dark text-white d-flex align-items-center justify-content-center" style="height: 50%; padding: 2px">-->
<!--            <span class="font-10">{{ filename }}</span>-->
<!--        </div>-->
<!--    </div>-->

    <div class="d-inline-flex justify-content-start align-items-center m-1" style="height: 25px" role="button" @click="followLink">
        <img :src="fileIcon" style="height: 24px; width: 24px">
        <span :class="textClass">{{ filename }}</span>
    </div>
</template>

<script>
export default {
    name: "FileItem",
    props: {
        filename: { typeof: String, default: ''},
        filelink: { typeof: String, default: ''},
        fontsize: { typeof: Number, default: 10 }

    },
    methods: {
        parseName() {
            this.extension = this.filename.split('.').pop();
        },
        followLink() {
            window.open(this.filelink, '_blank');
        }
    },
    computed: {
        fileIcon() {
            switch (this.extension.toLowerCase()) {
                case 'docx':
                case 'doc':
                    return '/images/custom/word.png';
                case 'xlsx':
                case "xls":
                    return '/images/custom/excel.png';
                case 'pdf':
                    return '/images/custom/pdf.png';
                case "jpg":
                case "jpeg":
                    return '/images/custom/jpg.png';
                case "csv":
                    return '/images/custom/csv.png';
                case "bmp":
                    return '/images/custom/bmp.png';
                case "gif":
                    return '/images/custom/gif.png';
                case "png":
                    return '/images/custom/png.png';
                case "tiff":
                    return '/images/custom/tiff.png';
                default:
                    return '/images/custom/editicon1.png';
            }
        },
        textClass() {
            const font = 'font-' + this.fontsize;
            if(this.fontsize > 12) {
                return 'ml-1 attribute-label ' + font;
            }

            return 'ml-1 mt-1 attribute-label ' + font;
        },

    },
    mounted() {
        this.parseName();
    },
    data() {
        return {
            extension: '',
        }
    }
}
</script>

<style scoped>

</style>
