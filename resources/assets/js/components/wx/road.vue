<template>
    <div>
        <h4>学习路线</h4>
        <div id="content">

        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {

            }
        },
        mounted () {
            axios.get('/Road/getRoad').then(res=>{
                if(res.data.code == 0){
                    document.getElementById('content').innerHTML = res.data.result.content;
                }
            })
        }
    }
</script>

<style>
    .head{
        margin-top: 10px;
        font-size: 20px;
    }
    img{
        display: block;
        margin: 0 auto;
        width: 90%;
        margin-top: 30px;
    }
    a{
        display: inline-block;
        margin: 20px 0 0 15px;
        text-decoration: none;
        color: rgb(13, 92, 212);
    }

    p{
        margin: 0;
        margin-top: 5px;
        font-size: 13px;
    }
    h4{
        font-size: 14px;
        margin: 15px 0;
    }
</style>