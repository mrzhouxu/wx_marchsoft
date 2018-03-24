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
			    <el-row :gutter="20">
					<el-col :span="12">
						<div style="text-align:center;margin-bottom: 10px;">
							 <el-button>题目</el-button>
						</div>
					 		<UE ref="ue"></UE>
					</el-col>
					<el-col :span="12">
					  	<div class="grid-content bg-purple-light">
					  		<div style="text-align:center;margin-bottom: 10px;">
							 <el-button>答案</el-button>
						</div>
					  		<UE ref="ue2"></UE>
					  	</div>
					</el-col>
				</el-row>
		    </el-form>
		  </span>
		</el-dialog>
    </div>
</template>

 <script>
	import UE from '../../../utf8-php/UEditor.vue'
    export default {
    	 components:{
	        UE
	     },
	    data() {
		    return {
		      tableData: [],	//记录
		      dialogVisible:false,
		      b_editor:false,	//每次打开遮罩层只创建一次编辑器
		      title:"",
		      title2:"",		//标题备份（用于比较是否改变）
		      type:"",			
		      type2:"",			//类型备份
		      content:"",		//题目备份
		      answer:"",		//代码备份
		      currentId:0,		//当前id
		      currentPage1: 1,
		      pagesNumber:10,	//每页显示记录数
		      recorNumber:0		//总记录数
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
						window.location.reload();
					});
				}
	    	},
	    	onlyCreatEditor:function(id){
	    		this.dialogVisible = true;	//显示遮罩层
	    		this.currentId=id;
	    		this.setEditorData(id);
	    	},

	    	setThenData:function(result){
	    		this.title=result[0].title;
	    		this.title2=result[0].title;
	    		this.type=result[0].type;
	    		this.type2=result[0].type;
	    		this.$refs.ue.setUEContent(result[0].content);
	    		this.content=result[0].content;
	    		this.$refs.ue2.setUEContent(result[0].answer);
	    		this.answer=result[0].answer;
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
	      	handleClose(done) {
	      		console.log("关闭遮罩层");
	      		if (this.title!=this.title2||this.type!=this.type2||this.content!=this.$refs.ue.getUEContent()||this.answer!=this.$refs.ue2.getUEContent()) {
	      			console.log(this.answer!=this.$refs.ue2.getUEContent());
	      			this.updateAlgorithm();
	      		}
	            done();
	      	},
	      	updateAlgorithm:function(){
	      		if(confirm("你修改了内容，确定要更改吗？")){
		          	if(this.title=="")
			            alert("标题不能为空");
		          	else if(this.$refs.ue.getUEContent()=="")
		            	alert("题目不能为的空");
		          	else if(this.$refs.ue2.getUEContent()=="")
			            alert("答案代码不能为空");
		          	else{
		      			if(this.type2=="")
			            	this.type2="无";
  			    		axios.post('/admin/weeklyExercise/update',{
			    			id:this.currentId,
	    		        	title:this.title2,
	        				keyword:this.type2,
	        				subject:this.$refs.ue.getUEContent(),
	        				answer:this.$refs.ue2.getUEContent()
	    				})
						.then(function(response){
							alert(response.data.msg);
						});
		          	}
				}else{
					alert("终止了修改");
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

