<template>
    <div>
        <UE ref="ue">

        </UE>
        <el-button type="primary"  @click="submitContent()">提交</el-button>
    </div>
</template>
<script>
    import UE from '../../../utf8-php/editor.vue';
    export default{
        components:{
            UE
        },
        data(){
          return{
              content:''
          }
        },
        methods:{
            submitContent(){
                let self = this;
                let content = this.$refs.ue.getUEContent();
                axios.post('/Contact/updateContent',{content:content}).then(
                    res=>{
                        if(res.data.code == 0){
                            self.$message({
                                message: '修改成功',
                                type: 'success'
                            });
                        }else{
                            self.$message.error('修改失败');
                        }
                    }
                ).catch(function () {
                    self.$message.error('哎呀妈呀！出错了，请刷新一下。');
                })

            },

        },
        mounted:function () {

            axios.get('/Contact/getContent').then(
                res=>{
                    if(res.data.code == 0){
                        this.content = res.data.result.content;
                        console.log(this.content)
                        this.$refs.ue.setUEContent(this.content);
                     }  
                }
            )


        }

    }

</script>