<template>
    　　<div :id="id">
    　　</div>
</template>
<style scoped>
</style>
<script>
    import './ueditor.config.js'
    import './ueditor.all.min.js'
//    import './ueditor.parse.min.js'
    import './lang/zh-cn/zh-cn.js'



    export default {
        props: {
        },
        data(){
            return {
                id: Math.ceil(Math.random()*100000) + 'editor'
            }
        },
        mounted() {
            this.editor = UE.getEditor(this.id)   // 获取编辑器实例化的对象
        },
        methods: {
            getUEContent() { // 获取内容方法
                return this.editor.getContent()
            },
            setUEContent(val){
                this.editor.setContent(val)
            }

        }
    }
</script>