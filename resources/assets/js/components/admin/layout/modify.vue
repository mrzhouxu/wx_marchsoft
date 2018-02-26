<template >
	<div class="view">
<el-form  :label-position="labelPosition" :model="ruleForm2" :rules="rules2" ref="ruleForm2" label-width="100px" class="demo-ruleForm" >
	<el-form-item label="id" prop="id" v-if="visible">
    <el-input  v-model="ruleForm2.id" auto-complete="off" ></el-input>
  </el-form-item>
  <el-form-item label="班级" prop="class">
    <el-input  v-model="ruleForm2.class" auto-complete="off" ></el-input>
  </el-form-item>
  <el-form-item label="姓名" prop="name">
    <el-input v-model="ruleForm2.name" auto-complete="off"></el-input>
  </el-form-item>
  <el-form-item label="性别" prop="sex">
    <el-input v-model="ruleForm2.sex" auto-complete="off"></el-input>
  </el-form-item>
  <el-form-item label="学号" prop="NO">
    <el-input v-model="ruleForm2.NO" auto-complete="off"></el-input>
  </el-form-item>
  <el-form-item label="联系电话" prop="phone">
    <el-input v-model="ruleForm2.phone" auto-complete="off"></el-input>
  </el-form-item>
  <el-form-item label="方向" prop="dretion">
    <el-input v-model="ruleForm2.dretion" auto-complete="off"></el-input>
  </el-form-item>
  <el-form-item>
    <el-button type="primary" @click="submitForm('ruleForm2')">提交</el-button>
    <el-button @click="resetForm('ruleForm2')">重置</el-button>
  </el-form-item>
</el-form>
</div>
</template>
<style type="text/css">
	.view{
		width: 80%;
	}
	.id{
		width: 0;
		height: 0;
	}
</style>

<script type="text/javascript">
	export default{
		components:{

		},
		data(){
		
	      var validateclass = (rule, value, callback) => {
	        if (value === '') {
	          callback(new Error('请输入班级'));
	        } 
	        else{
	        	callback();
	        }
	      };
	      var validatename = (rule,value,callback)=>{
	      	if (value==='') {
	      		callback(new Error('姓名不能为空'));
	      	}
	      	else{
	      		callback();
	      	}	
	      };
	       var validatesex = (rule,value,callback)=>{
	      	if (value==='') {
	      		callback(new Error('性别不能为空'));
	      	}else if(value!=="男"&&value!=="女"){
	      		callback(new Error('请输入正确的值'));
	      	}
	      	else{
	      		callback();
	      	}
	      };

	      var validateno = (rule, value, callback) => {
	        if (value === '') {
	          callback(new Error('学号不能为空'));
	        } else if (value.length!=11) {
	          callback(new Error('学号必须为11位!'));
	        } 
	        else{
	        	callback();
	        }
	      };
	      var validatephone = (rule, value, callback) => {
	        if (value === '') {
	          callback(new Error('联系方式不能为空'));
	        } else if (value.length!=11) {
	          callback(new Error('学号必须为11位!'));
	        } 
	        else{
	        	callback();
	        }
	      };
	      var validatedretion = (rule, value, callback) => {
	        if (value === '') {
	          callback(new Error('方向不能为空'));
	        } else if (value!='美工'&&value!='开发') {
	          callback(new Error('对不起,我们没有这个方向！'));
	        } 
	        else{
	        	callback();
	        }
	      };
      return {
      	labelPosition:'top',
      	visible:false,
        ruleForm2: {
          class: '',
          name: '',
          sex: '',
          NO:'',
          phone:'',
          dretion:'',
          id:'',
        },
        rules2: {
          class: [
            { validator: validateclass, trigger: 'blur' }
          ],
          name:[
          { validator:validatename,trigger:'blur'}
          ],
          sex:[
           { validator:validatesex,trigger:'blur'}
          ],
          NO: [
            { validator: validateno, trigger: 'blur' }
          ],
          phone: [
            { validator: validatephone, trigger: 'blur' }
          ],
          dretion: [
            { validator: validatedretion, trigger: 'blur' }
          ],
        },
      };
		},
		methods:{
		submitForm(formName) {
        	this.$refs[formName].validate((valid)=>{
		      if (valid) {
	             const  postdata={
	             	id:this.ruleForm2.id,
	             	class:this.ruleForm2.class,
	             	name:this.ruleForm2.name,
	             	sex:this.ruleForm2.sex,
	             	NO:this.ruleForm2.NO,
	             	phone:this.ruleForm2.phone,
	             	dretion:this.ruleForm2.dretion

	             }
		        axios.post('/admin/modify',postdata).then(res=>{
		                    if(res.data.code == 0){
		                        this.$message({
		                        type: 'success',
		                        message: '修改成功！'
		                        });
		                    }else{
		                        this.$message({
		                        type: 'error',
		                        message: '修改失败!'
		                        });
		                    }
		                 }).catch(function(response){
                			this.$message({
                      		message: '提交失败',
                      			type: 'error'
                    			});
             				})

		      } else {
		        console.log('error submit!!');
		        return false;
		      }
        	});
      },
      resetForm(formName) {
         var index =this.$route.params.indexs;
        this.ruleForm2.id=index.id;
		this.ruleForm2.class=index.class;
		this.ruleForm2.name=index.name;
		this.ruleForm2.sex=index.sex;
		this.ruleForm2.NO=index.NO;
		this.ruleForm2.phone=index.phone;
		this.ruleForm2.dretion=index.dretion;
      },
      init(){
        var index =this.$route.params.indexs;
        this.ruleForm2.id=index.id;
		this.ruleForm2.class=index.class;
		this.ruleForm2.name=index.name;
		this.ruleForm2.sex=index.sex;
		this.ruleForm2.NO=index.NO;
		this.ruleForm2.phone=index.phone;
		this.ruleForm2.dretion=index.dretion;
		
      }
		},
		mounted(){
			this.init();
		     
			
		}
	}

</script>