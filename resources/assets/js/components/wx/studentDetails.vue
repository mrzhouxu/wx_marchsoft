<template>
	<div>
		<div style="width: 100%;height: 50px;background-color: white">

			<p style="width: 100%;margin: 0 auto;height: 20px;padding: 15px 0;font-size: 15px;text-align: center;color: black;background-color: rgb(77, 147, 219);position: fixed">
				<a href="/wx#/student"><img style="float:left;width: 18px;margin: 0px 0px 0px 10px;" src="/img/back.png" /></a>
				<span style="margin-right: 8%;">三月软件</span>
			</p>

		</div>
		<div class="imgDiv">
			<img class="touxiang" :src="url">
		</div>
		<group>
			<x-input title="姓名" disabled v-model="name"></x-input>
			<x-input title="班级" disabled v-model="studentClass"></x-input>
			<x-input title="学院" disabled v-model="College"></x-input>
			<x-input title="手机" disabled v-model="phone"></x-input>
			<x-textarea title="简介" :readonly="read" v-model="Introduction" :height="250"></x-textarea>
		</group>
	</div>
</template>

<script>
import { XInput, Group, XTextarea } from 'vux';
import Router from 'vue-router';

Vue.use(Router)
export default {
	components: {
		XInput,
		Group,
		XTextarea
	},
	data() {
		return {
			read: true,
			url: '/img/student/m_fengmian.jpg',
			
			name: 'test',
			phone: '',
			studentClass: '',
			College: '',
			Introduction: ''
		}
	},
	mounted() {
		let object = this;
		axios.get('/student/getStudent?pid='+this.$route.params.pid).then(res=>{
			console.log(res.data.result.avator)
			if(res.data.code == 0){
				if(res.data.result.avator != null && res.data.result.avator!="")
					object.url = 'http://www.marchsoft.cn/Common/img/photo/photo/m_'+res.data.result.avator
				object.name = res.data.result.user_name
				object.phone = res.data.result.user_phone
				object.studentClass = res.data.result.class
				object.College = res.data.result.department
				object.Introduction = res.data.result.describe
			}
		})
	},

}
</script>

<style>
* {
  margin: 0;
  padding: 0;
}
.imgDiv {
  height: 160px;
  width: 100%;
  padding-top: 40px;
}

.touxiang {
  display: block;
  margin: 0 auto;
  width: 80px;
  height: 80px;
  border-radius: 50%;
}
.weui-cell:before {
  display: none;
}
.weui-cell {
  border-bottom: 1px solid #d9d9d9;
}
</style>