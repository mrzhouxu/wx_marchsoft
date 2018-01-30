<template>
    <div>
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>三月后台</el-breadcrumb-item>
                <el-breadcrumb-item>发布算法</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
		<el-form >
		    <el-form-item label="标题" >
		    	<el-input v-model="title" autofocus></el-input>
		    </el-form-item>
		    <el-form-item label="关键字" > 
		     	<el-input v-model="keyword"></el-input>
		    </el-form-item>
		    <el-form-item label="题目" >
		        <div id="editorElem">
			    </div>
		    </el-form-item>	
	       	<el-form-item label="代码">
			    <div id="editorElem2">
			    </div>
		    </el-form-item>
		    <el-form-item>
		      <el-button v-on:click="getContent">确认提交</el-button>
		    </el-form-item>
		</el-form>
    </div>
</template>

<script>

import E from 'wangeditor'

   export default {
      name: 'editor',
      data () {
        return {
        	title:'',
        	keyword:''
        }

      },
      methods: {
        getContent: function () {
          if(this.keyword=="")
            this.keyword="空";
          if(this.title=="")
            alert("标题不能为空");
          else if(this.editor.txt.text()=="")
            alert("题目不能为的空");
          else if(this.editor2.txt.text()=="")
            alert("答案代码不能为空");
          else{
    				axios.post('/admin/weeklyExercise/add',{
    		        title:this.title,
        				keyword:this.keyword,
                subject:this.editor.txt.text(),
                answer:this.editor2.txt.text()
    				})			
    				.then(function(response){
    					alert(response.data.msg);
              if(response.data.code<2)
    		        window.location.reload();
    				});
          }
        },
        createeditor:function(divname){
          var self=this;
          this.dialogVisible = true;
          var editor = new E(divname);
            editor.customConfig.onchange = (html) => {
              this.subject = html
            };
            editor.customConfig.menus = [
              'head',  // 标题
            'bold',  // 粗体
            'italic',  // 斜体
            'underline',  // 下划线
            'strikeThrough',  // 删除线
            'foreColor',  // 文字颜色
            'backColor',  // 背景颜色
            'link',  // 插入链接
            'list',  // 列表
            'justify',  // 对齐方式
            'quote',  // 引用
            'emoticon',  // 表情
            'image',  // 插入图片
            'table',  // 表格
            'code',  // 插入代码
          ]
          editor.create();
          return editor;
        }
      },
      mounted() {
        this.editor=this.createeditor('#editorElem');
        this.editor2=this.createeditor('#editorElem2');
      }
    }
</script>

