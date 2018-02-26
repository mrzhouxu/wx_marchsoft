<template>
 <div> 
 	 <div class="select">
 	  <el-select v-model="value" clearable placeholder="请选择查询字段">
		<el-option
		      v-for="item in options"
		      :key="item.value"
		      :label="item.label"
		      :value="item.value">
		    </el-option>
		</el-select>
 	 </div>
	  <div class="sou">
		 	<el-input
			  placeholder="请输入查询的值"
			  icon="search"
			  v-model="input"
			  :on-icon-click="handleIconClick">
			</el-input>
	  </div>
	 <div class="back">
	  <el-button 
	  :plain="true" 
	  v-if="show" 
	  ype="success"
	  class="back"
	   @click="back">
	   返回
	   </el-button>
 	</div>
 	<div class="export" v-if="see">
	 	 <el-button type="success"
	 	  @click="expot">
	 		导出表格
	      </el-button>
 	</div>
 <el-table
    :data="tableData"
    style="width: 100%"
    max-height="500">
    <el-table-column
      prop="id"
      label="id"
      v-if="visible">

    </el-table-column>
    <el-table-column
      prop="class"
      label="班级"
      width="130">
    </el-table-column>


    <el-table-column
      prop="name"
      label="姓名"
      width="130">
    </el-table-column>
     <el-table-column
      prop="sex"
      label="性别"
      width="110">
    </el-table-column>
    <el-table-column
      prop="NO"
      label="学号"
      width="130">
    </el-table-column>
    <el-table-column
      prop="phone"
      label="联系方式"
      width="130">
    </el-table-column>
    <el-table-column
      prop="dretion"
      label="方向"
      width="130">
    </el-table-column>
     <el-table-column
      prop="cost"
      label="费用"
      width="110">
    </el-table-column>
    <el-table-column
      label="操作">
      <template slot-scope="scope">
        <el-button
          @click.native.prevent="deleteRow(scope.$index, tableData)"
          type="text"
          size="small">
          移除
        </el-button>
        <el-button 
     		@click.native.prevent="modifyteRow(scope.$index, tableData)"
          type="text"
          size="small" >
          修改
        </el-button>
      </template>
    </el-table-column>
  </el-table>
  <div class="page">
 	 <el-pagination
      @current-change="handleCurrentChange"
      :current-page="currentPage1"
      :page-size="10"
      layout="total, prev, pager, next, jumper"
      :total="total">
    </el-pagination>
 </div>
 </div>
 
</template>

<style type="text/css">
.sou{
	margin-bottom: 20px;
	width: 20%;
	float: left;
}
.back{
	float: left;
	margin-left: 20px;
}
.select{
	width: 15%;
	float: left;
	margin-right: 30px;
}
.export{
	float: right;
}

</style>
<script type="text/javascript">

	export default{
		components:{

		},
		data(){
			return {
				visible:false,
          		tableData: [],
          		data:[],
          		currentPage1: 1,
          		total:0,
          		input: '',
          		show:false,
          		see:true,
          		posts:{},
          		 options: [{
			          value: 'class',
			          label: '班级'
			        }, {
			          value: 'name',
			          label: '姓名'
			        }, {
			          value: 'sex',
			          label: '性别'
			        }, {
			          value: 'NO',
			          label: '学号'
			        }, {
			          value: 'phone',
			          label: '电话'
			        }, {
			        	value:'dretion',
			        	label:'方向'
		
		        }],
        		value: ''
        	}
		},
		methods:{
			deleteRow(index, rows) {    //删除信息
				this.$confirm('确定删除吗？', '提示', {
                      confirmButtonText: '确定',
                      cancelButtonText: '取消',
                      type: 'warning'
                 }).then(() => {
                 	 var no =rows[index].NO;
                      rows.splice(index, 1);
                     axios.post('/admin/del/'+no).then(res=>{
                        if(res.data.code == 0){
                            this.$message({
                            type: 'success',
                            message: '删除成功！'
                            });
                        }else{
                            this.$message({
                            type: 'error',
                            message: '删除失败!'
                            });
                        }
                     })
                }).catch(() => {
                      this.$message({
                        type: 'info',
                        message: '取消删除'
                      });
                });
				
           
		       },
		       modifyteRow(index,rows){   //修改信息
		        this.$router.push({name:'修改信息', params: { indexs:rows[index] }});
		       },
		      handleCurrentChange(val) {   //分页
		      	var self = this;
		          axios('/admin/train/change_page?page='+val).then( function(res) {
		          		if (res.data.code==1){
		          			this.$message({
		                            type: 'error',
		                            message: '查询失败!'
		                            });
		          			
		          		}else{
		          			self.tableData=res.data.data;
		          		}
		          });

		      },
		       handleIconClick(ev) {   //查询信息
		     		 var parameter=0;
		     		 if (this.input&&this.value) {
		     		 	var self =this;
		     		 	if (this.value=='class') {
		     		 		parameter=0;
		     		 	}else if (this.value=='sex') {
		     		 		parameter=1;
		     		 	}else if (this.value=='dretion') {
		     		 		parameter=2;
		     		 	}
		     		 		const postdata={
		     		 		where:this.value,
		     		 		val:this.input,
		     		 		parameter:parameter,
		     		 	}

                          this.posts=postdata;
		     		 	axios.post('/admin/train/search',postdata).then( function(res){
		     		 			if (res.data.code==1) {
		     		 				this.$message({
		                            type: 'error',
		                            message: '查询失败!'
		                            });
		     		 			}else{
		     		 				self.tableData=res.data.data;
		     		 				self.show=true;
		     		 				self.total=res.data.total;
		     		 				if (self.value=='name'||self.value=='NO'||self.value=='phone') {
		     		 					self.see=false;
		     		 				}
		     		 			}
		     		 	}).catch(function(){
		     		 		 this.$message.error('请求错误');
		     		 	});	
		     		 }else{
		     		 	 this.$message({
				          message: '不能为空哦！',
				          type: 'warning'
				        });
		     		 }
		   		},
		   		back(){
		   			var self = this;
					axios.get('/admin/train/people').then(function(res){
		              self.tableData=res.data.data;
		              self.total=res.data.total;
		              self.value='';
					}, function(){
							this.$message.error('请求错误');
					})
					self.show=false;
					self.input='';
					self.see=true;
		   		},
		   		expot(){

		   			this.$confirm('确定导出表格内容到Excel吗？', '提示', {
                      confirmButtonText: '确定',
                      cancelButtonText: '取消',
                      type: 'warning'
                 }).then(() => {
                 	var self=this;
                 	axios.get('/admin/train/export',this.input).then(function(res){
  
                 	}).catch(function(res){

                 	})

                 }).catch(()=>{

                 });
		   		}
   		
		},
		mounted(){
			var self = this;
			axios.get('/admin/train/people').then(function(res){
              self.tableData=res.data.data;
              self.total=res.data.total;
              
			}, function(){
					this.$message.error('请求错误');
			})
		}
	}

</script>