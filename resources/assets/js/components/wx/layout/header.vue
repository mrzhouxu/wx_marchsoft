<template>
    <div class="my_header header">
        <img :src="img_url" alt="" class="img_url">
        三月报名
        <img :src="image_url" alt="" class="image_url">
    </div>
</template>
<style>
    *{
        margin: 0;
        padding: 0;
    }
    .my_header{
        width: 100%;
        height: 70px;
        line-height: 70px;
        text-align: center;
        font-size: 25px;
        color: white;
        background-color: #17195f;
        background-image: url(/img/star.gif);
        position: relative;
    }
    .img_url{
        width: 100px;
        height: 100px;
        position: absolute;
        left: 0;
        top: 10px;
    }
    .image_url{
        width: 100px;
        height: 100px;
        position: absolute;
        right: 0;  
        bottom:0; 
    }
</style>
<script>
    export default {
        data() {
            return {
                img_url : '/img/rabit.png',
                image_url : '/img/moon.png'
            }
        },
        methods: {

        },
    }
</script>