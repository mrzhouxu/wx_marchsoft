<template>
   
    <div v-loading="loading" style="width: 100%; padding-top: 30px;">
        标题:
        <div style="width: 30%;display: inline-block;margin-bottom: 5px;">
            <el-input v-model="news.title" placeholder="请输入题目" @change="change"></el-input>
        </div>
        <div>
            <el-checkbox v-model="news.checked">是否置顶</el-checkbox>
        </div>
        <UE ref="ue"></UE>
        <el-button type="primary" @click="submitNew()">提交</el-button>
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
                checked: false,
                id: 0
            },
            loading: false,
            titleChange: false,
            contentChange: false,
        }
    },
    methods: {
        change() {
            this.titleChange = true;
        },

        submitNew() {

            let content = this.$refs.ue.getUEContent();//在这里调用了子组件ueditor组件的getContent()方法
            if(this.news.content != content){
                this.contentChange = true;
            }
            this.news.content = content;
            let judge = this.judgeNUll();
            if (judge == 0) {
                let path = '/News/add';
                if (this.news.id != 0) {
                    path = '/News/update'
                }
               if(this.titleChange || this.contentChange){
                    axios.post(path, { news: this.news }).then(res => {
                    if (res.data.code == 0) {
                        this.$message({
                            message: '添加成功',
                            type: 'success'
                        });
                        //                    setTimeout( "reidrectToItem()",1000)
                        this.timeOut = setTimeout(() => {
                            this.$router.push({ name: "新闻列表" })
                        }, 3000)


                    } else if (res.data.code == 0) {
                        this.$message.error('添加失败');
                    } else if (res.data.code == 2) {

                    }
                })
               }else{
                   this.$message.error('文章整体内容未改动不得更新');
               }
            } else if (judge == 1) {
                this.$message.error('标题为空');
            } else {
                this.$message.error('内容为空');
            }

        },
        judgeNUll() {
            if (this.news.title == "" || this.news.title == null) {
                return 1
            } else if (this.news.content == "" || this.news.content == null) {
                return 2
            } else {
                return 0
            }
        },
        reidrectToItem() {
            alert("2");
        }
    },
    mounted() {
        try {
            let id = this.$route.params.newId.toString();
            if (id) {
                this.loading = true;
                axios.get('/News/getOneNew?pid=' + id).then(
                    res => {
                        this.news.title = res.data.result.news_title;
                        this.news.content = res.data.result.news_content;
                        this.$refs.ue.setUEContent(this.news.content);
                        if (res.data.result.news_stick > 0) {
                            this.news.checked = true;
                        } else {
                            this.news.checked = false;
                        }
                        this.news.id = res.data.result.idmarch_news;
                        this.loading = false;
                    }


                )
            }

        } catch (e) {
            console.log("gg")
        }

    }
}
</script>
<style>
.editer {
  height: 580px;
}
</style>