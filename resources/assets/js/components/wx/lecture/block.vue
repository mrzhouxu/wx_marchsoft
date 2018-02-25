<template>
    <div @click="sendParams">
        <panel :list="list" :type="type"></panel>
    </div>
</template>

<script>
    import { Panel } from 'vux'
    export default {
        data () {
            return {
                list: [{
                    src: this.img,
                    title: this.theme,
                    desc: this.content,
//                    url: {
//                        path: '/lecture/detaile'+this.theme,
//                        replace: false
//                    },
                    meta: {
                        source: this.user,
                        date: this.data,
                        other: this.sort
                    }
                }],
                type: '5',
            }
        },
        components: {
            Panel
        },
        methods: {
            sendParams() {
                this.$router.push({
                    path:'/lecture/detaile',
                    name:'详细视频',
                    params: {
                        theme:this.theme,
                        user:this.user,
                        content:this.content,
                        sort:this.sort,
                        data:this.data,
                        file:this.file,
                    }
                })
            }
        },
        props:['theme','user','content','data','img','file','sort']

    }
</script>

<style>
    .weui-media-box__thumb {
        height: 100% !important;
    }
    .weui-media-box__hd {
        height: 80px !important;
    }

</style>
<!--'theme='+this.theme+'&user='+this.user+'&content='+this.content+'&sort='+this.sort+'&file='+this.file,-->