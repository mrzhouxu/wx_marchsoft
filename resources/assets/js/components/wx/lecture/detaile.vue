<template>
    <div>
        <video :src="video.file" autoplay="autoplay"></video>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                video:{
                    theme:'',
                    user:'',
                    content:'',
                    data:'',
                    file:'',
                    sort:''
                }
            }
        },
        methods: {

        },
        created:function () {
            var route = this.$route.params;
            this.video.theme = route.theme;
            this.video.user = route.user;
            this.video.content = route.content;
            this.video.data = route.data;
            this.video.file= route.file;
            this.video.sort = route.sort;
        }
    }



</script>



<style>

</style>