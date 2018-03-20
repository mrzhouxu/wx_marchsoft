<template>
    <div class="container">
        <div class="box">
            <lec-block v-for="item in lectureAll"
                       :key="item.idmarch_lecture"
                       :theme="item.lecture_theme"
                       :user="item.lecture_user"
                       :content="item.lecture_content"
                       :data="item.lecture_date"
                       :img="item.lecture_img"
                       :file="item.lecture_file"
                       :sort="item.lecture_sort"
            ></lec-block>
            <!--<lec-block></lec-block>-->
            <div v-transfer-dom>
                <loading :show="show1" :text="text1"></loading>
            </div>
            <p class="box_p"  @click="increase">查看更多</p>
        </div>

    </div>
</template>

<script>
    import block from './block.vue'
    import { Loading,LoadingPlugin,TransferDomDirective as TransferDom } from 'vux'
    Vue.use(LoadingPlugin);
    export default {
        data() {
            return {
                lectureAll:[],
                page:0,
                show1: false,
                text1: 'Processing',
                a:false,
                number:5,

            }
        },
        directives: {
            TransferDom
        },
        methods: {
            onSubmit(i) {
                axios.get('lecture/getlecture',{
                    params:{
                        'page':i,
                        'number':this.number
                    }
                }).then(res =>{
                    if(res.data.code == 0) {
                        this.lectureAll = this.lectureAll.concat(res.data.result);
                    }
                })
            },
            increase() {
                this.showLoading();
                this.page+=1;
            },
            showLoading () {
                this.$vux.loading.show({
                    text: 'Loading'
                })
                setTimeout(() => {
                    this.$vux.loading.hide();
                }, 1000)
            },
        },
        created:function() {
            this.onSubmit(this.page)
        },
        watch: {
            'page':function(val) {
                this.onSubmit(val);
            }
        },
        components: {
            'lec-block':block,
            Loading
        }
    }
</script>

<style>

    .container {
        display: flex;
        flex-direction:column
    }
    .box {
        display: flex;
        flex-direction:column;

    }
    .box_p {
        text-align: center  ;
    }
</style>