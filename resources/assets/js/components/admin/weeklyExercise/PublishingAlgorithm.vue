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
        <el-tooltip class="item" effect="dark" content="Top Left 提示文字" placement="top-start">
          <el-button>题目</el-button>
        </el-tooltip>
　　　　<UE ref="ue"></UE>
        <br>
        <el-tooltip class="item" effect="dark" content="Top Left 提示文字" placement="top-start">
          <el-button>代码</el-button>
        </el-tooltip>
        <UE ref="ue2"></UE>
        <br>
		    <el-form-item>
		      <el-button v-on:click="getContent">确认提交</el-button>
		    </el-form-item>
		</el-form>
    </div>
</template>

<script>
import UE from '../../../utf8-php/UEditor.vue'


   export default {
      components:{
        UE
      },
      data () {
        return {
        	title:'',
        	keyword:''
        }

      },
      methods: {

        getContent: function () {
          let subject = this.$refs.ue.getUEContent();//在这里调用了子组件ueditor组件的getContent()方法
          let answer = this.$refs.ue2.getUEContent();
          if(this.title=="")
            alert("标题不能为空");
          else if(subject=="")
            alert("题目不能为的空");
          else if(answer=="")
            alert("答案代码不能为空");
          else{
            if(this.keyword=="")
            this.keyword="无";
    				axios.post('/admin/weeklyExercise/add',{
    		        title:this.title,
        				keyword:this.keyword,
                subject:subject,
                answer:answer
    				})			
    				.then(function(response){
    					alert(response.data.msg);
              if(response.data.code<2)
    		        window.location.reload();
    				});
          }
        }
      },
      mounted() {

      }
    }
</script>

<style>

</style>

