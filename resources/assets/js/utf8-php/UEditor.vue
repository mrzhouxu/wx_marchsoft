<template>
　　<div :id="id">
　　</div>
</template>

<script>
import './ueditor.config.js'
import './ueditor.all.min.js'              
import './ueditor.parse.min.js' 
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
		window.UEDITOR_CONFIG.toolbars = [[
	　　　　'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', 　　　　'|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', '|',
	　　　　'rowspacingtop', 'rowspacingbottom', 'lineheight', '|', 'fontfamily', 'fontsize','insertcode'
	　　]];
　　　　this.editor = UE.getEditor(this.id,{
	        initialFrameHeight: 200
	    });   // 获取编辑器实例化的对象
　　},
　　methods: {
　　　　getUEContent() { // 获取内容方法
	　　　　return this.editor.getContent()
	　　},
		setUEContent(val){
			this.editor.setContent(val);
		}
　　}
}
</script>