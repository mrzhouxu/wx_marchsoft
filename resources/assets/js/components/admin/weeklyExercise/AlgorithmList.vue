<template>
    <div>
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>三月后台</el-breadcrumb-item>
                <el-breadcrumb-item>算法列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
 		<div id="time">
	    <el-table
	      :data="tableData"
	      style="width: 100%">
  	      <el-table-column
	        prop="number"
	        label="试题编号"
	        width="180">
	      </el-table-column>
	      <el-table-column
	        prop="title"
	        label="试题名称"
	        width="180">
	      </el-table-column>
  	      <el-table-column
	        prop="type"
	        label="关键字"
	        width="180">
	      </el-table-column>
	      <el-table-column
	        prop="time"
	        label="发表日期"
	        width="280">
	      </el-table-column>
  	      <el-table-column
	        prop="enter"
	        label="进入试题">
	        <template slot-scope="s">
	        	<a href="javascript:;" style="color:blue" @click="onlyCreatEditor(s.row.id)">打开</a>
	        </template>
	      </el-table-column>
	      <el-table-column
	        prop="enter"
	        label="删除">
	        <template slot-scope="s">
	        	<el-button size="mini" @click="deleteAlgorithm(s.row.id)">
	        		<i class="ion-trash-a"></i>
	        	</el-button>
	        </template>
	      </el-table-column>
	    </el-table>
 		</div>

	  <template>
		  <div class="block">
		    <el-pagination
		      @current-change="handleCurrentChange"
		      :current-page.sync="currentPage1"
		      :page-size="pagesNumber"
		      layout="total, prev, pager, next"
		      :total.sync="recorNumber">
		    </el-pagination>
		  </div>
		</template>

	    <el-dialog
		  title="详细信息"
		  :visible.sync="dialogVisible"	
		  size="large"
		  :before-close="handleClose"
		  top="1%">
		  <span slot="footer">
		  	<el-form >
			    <el-form-item label="标题">
			    	<el-input :value='title' v-model="title2"></el-input>
			    </el-form-item>
			    <el-form-item label="关键字" width="200"> 
			     	<el-input :value='type' v-model="type2"></el-input>
			    </el-form-item>
			    <el-row :gutter="24" >
					<el-col :span="12">
					 	<div class="grid-content bg-purple">
				        	<div id="editorElem" style="text-align: left;"></div>
					  	</div>
					</el-col>
					<el-col :span="12">
					  	<div class="grid-content bg-purple-light">
				    		<div id="editorElem2" style="text-align: left;"></div>
					  	</div>
					</el-col>
				</el-row>
		    </el-form>
		  </span>
		</el-dialog>
    </div>
</template>

 <script>
	import E from 'wangeditor'
    export default {
	    data() {
		    return {
		      tableData: [],
		      dialogVisible:false,
		      b_editor:false,
		      title:"",
		      title2:"",
		      type:"",
		      type2:"",
		      content:"",
		      answer:"",
		      currentId:0,
		      currentPage1: 1,
		      pagesNumber:10,
		      recorNumber:0
		    }
		},
	    methods: {
	    	getAlgorithm: function(myfirst,mytail){
	    		var self = this;
				axios.post('/admin/weeklyExercise/get',{
							first:myfirst,
	    		        	tail:mytail
    		        }).then(function (res) {
                    self.tableData = res.data.result.algorithmsall;
                    self.recorNumber=res.data.result.alogrithmnumber;
	            })
	    	},
	    	deleteAlgorithm: function(val){
	    		if(confirm("你确定要删除吗？")){
		    		axios.post('/admin/weeklyExercise/delete/'+val)			
					.then(function(response){
						alert(response.data.msg);
						// window.location.reload();
					});
				}
	    	},
	    	onlyCreatEditor:function(id){
	    		this.dialogVisible = true;
	    		if(!this.b_editor){
	    			this.editor=this.createeditor('#editorElem');
	    			this.editor2=this.createeditor('#editorElem2');
	    			this.b_editor=true;
	    		}
	    		this.currentId=id;
	    		this.setEditorData(id);
	    	},
	    	setThenData:function(result){
	    		this.title=result[0].title;
	    		this.title2=result[0].title;
	    		this.type=result[0].type;
	    		this.type2=result[0].type;
    			this.editor.txt.text(result[0].content);
	    		this.content=this.editor.txt.text();
    			this.editor2.cmd.do('insertHTML','<pre><code>'+ result[0].answer +'</code><pre>');
    			this.answer=this.editor2.txt.text();
 	    	},

	    	setEditorData:function(id){
	    		let data=this.SingleInformation(id);
	    		data.then(this.setThenData)
	    	},

	    	SingleInformation:function(id){
	    		return axios.post('/admin/weeklyExercise/selectsingle/'+id)			
					.then(function(response){
						if(response.data.code==1){
							return response.data.result;
						}
						else
							alert(response.data.msg);
						// window.location.reload();
					});
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
	    	},
	      	handleClose(done) {
	      		if (this.title!=this.title2||this.type!=this.type2||this.content!=this.editor.txt.text()||this.answer!=this.editor2.txt.text()) {
	      			this.updateAlgorithm();
	      		}
	      		this.editor2.txt.clear();
	            done();
	      	},
	      	updateAlgorithm:function(){
	      		if(confirm("你修改了内容，确定要更改吗？")){
	      			if(this.type2=="")
			            this.type2="无";
		          	if(this.title=="")
			            alert("标题不能为空");
		          	else if(this.editor.txt.text()=="")
		            	alert("题目不能为的空");
		          	else if(this.editor2.txt.text()=="")
			            alert("答案代码不能为空");
		          	else{
  			    		axios.post('/admin/weeklyExercise/update',{
			    			id:this.currentId,
	    		        	title:this.title2,
	        				keyword:this.type2,
	        				subject:this.editor.txt.text(),
	        				answer:this.editor2.txt.text()
	    				})
						.then(function(response){
							alert(response.data.msg);
						});
		          	}
				}else{
					console.log("no");
				}
	      	},
	      	handleCurrentChange(val) {
		        this.getAlgorithm((val-1)*this.pagesNumber,this.pagesNumber);
	      	}

	    },
	     created(){
            this.getAlgorithm(0,this.pagesNumber);
        },
    }
  </script>

<style>
  .el-dialog__body{
  	padding: 0;
  }
</style>

