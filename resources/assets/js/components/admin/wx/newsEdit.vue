<template>

    <div v-loading="loading" style="width: 100%; padding-top: 30px;">
        标题:
        <div style="width: 30%;display: inline-block;margin-bottom: 5px;">
            <el-input v-model="news.title" placeholder="请输入题目"></el-input>
        </div>
        <div>
            <el-checkbox v-model="news.checked">是否置顶</el-checkbox>
        </div>
        <UE ref="ue"></UE>
        <el-button type="primary"  @click="submitNew()">提交</el-button>
    </div>

</template>
<script>
    import UE from '../../../utf8-php/editor.vue';

    export default {
        components: {
            UE
        },
        data() {
            return {
                news: {
                    title: '',
                    content: '',
                    checked:false,
                    id:0
                },
                loading:false
            }
        },
        methods: {


            submitNew() {
                let content = this.$refs.ue.getUEContent();//在这里调用了子组件ueditor组件的getContent()方法
                this.news.content = content;
                let path = '/News/add';
                if(this.news.id != 0){
                    path = '/News/update'
                }
                axios.post(path,{news:this.news}).then(res => {
                    if(res.data.code == 0){
                        this.$message({
                            message: '添加成功',
                            type: 'success'
                        });
//                    setTimeout( "reidrectToItem()",1000)
                        this.timeOut = setTimeout(()=>{
                            this.$router.push({name:"新闻列表"})
                        },3000)


                    }else if(res.data.code == 0){
                        this.$message.error('添加失败');
                    }else if(res.data.code == 2){
                        
                    }
                })

            },
            reidrectToItem(){
                alert("2");
            }
        },
        mounted() {
            try {
                let id = this.$route.params.newId.toString();
               if(id){
                   this.loading = true;
                   axios.get('/News/getOneNew?pid='+id).then(
                       res=>{
                           this.news.title = res.data.result.news_title;
                           this.news.content =  res.data.result.news_content;
                           this.$refs.ue.setUEContent(this.news.content);
                           if( res.data.result.news_stick>0){
                               this.news.checked = true;
                           }else{
                               this.news.checked = false;
                           }
                           this.news.id = res.data.result.idmarch_news;
                           this.loading = false;
                       }


                   )
               }

            }catch (e){
                console.log("gg")
            }

        }
    }
</script>
<style>
    .editer {
        height: 580px;;
    }
</style>