<template>
    <!--<QRCodeVue3
            v-if="telemedicine"
            :value="patient_code"
            :width="100"
            :height="100"
    />-->
    <div id="qr-container" v-if="telemedicine">
        <QRCodeVue3
                :width="100"
                :height="100"
                :value="patient_code"
                :qrOptions="{ typeNumber: 0, mode: 'Byte', errorCorrectionLevel: 'H' }"
                :imageOptions="{ hideBackgroundDots: true, imageSize: 0.4, margin: 0 }"
                :dotsOptions="{
                    type: 'dots',
                    color: '#4bb543',
                    gradient: {
                    type: 'linear',
                    rotation: 0,
                    colorStops: [
                        { offset: 0, color: '#4bb543' },
                        { offset: 1, color: '#4bb543' },
                    ],
                    },
                }"
                :backgroundOptions="{ color: '#ffffff' }"
                :cornersSquareOptions="{ type: 'dot', color: '#000000' }"
                :cornersDotOptions="{ type: undefined, color: '#000000' }"
                fileExt="png"
                :download="true"
                myclass="my-qur"
                imgclass="img-qr"
                downloadButton="my-button"
                :downloadOptions="{ name: 'vqr', extension: 'png' }"
        />
    </div>
</template>

<script>
    import QRCodeVue3 from "qrcode-vue3";
    export default {
        name: 'QrApp',
        props : ["patient_code","telemedicine"],
        components: {
            QRCodeVue3
        },
        created() {
            console.log(this.patient_code)
            console.log(this.telemedicine)
        }
    }
</script>


