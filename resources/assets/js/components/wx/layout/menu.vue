<template>
    <div>
        <div>
            <tab :line-width=2 active-color='rgb(22,25,94)' v-model="index" >
                <tab-item class="vux-center" :selected="demo2 === item" v-for="(item, index) in list" @click="demo2 = item" :key="index">{{item}}
                </tab-item>
            </tab>

            <swiper height="545px" :show-dots="false" v-model="index">
                <swiper-item v-model="form">
                    <group>
                        <x-input title="姓名" v-model="form.name" name="userName" placeholder="请输入姓名" is-type="china-name"></x-input>
                    </group>
                    <group>
                        <x-input title="班级" v-model="form.grade" name="userClass" placeholder="请输入班级"></x-input>
                    </group>
                    <group class="sex2">
                        <selector direction="right" v-model="form.sex" title="性别" :options="list2"></selector>
                    </group>
                    <group>
                        <x-input title="学号" v-model="form.student_id" name="userNumber" placeholder="请输入学号"></x-input>
                    </group>
                    <group>
                        <x-input title="手机号码" v-model="form.phone_num" name="mobile" placeholder="请输入手机号码" keyboard="number" is-type="china-mobile"></x-input>
                    </group>
                    <group>
                        <x-input title="验证码" class="weui-vcode" placeholder="请输入验证码">
                            <x-button class="sice" slot="right" type="primary" mini>发送验证码</x-button>
                        </x-input>
                    </group>
                    <checker v-model="form.radio" default-item-class="demo2-item" selected-item-class="demo2-item-selected" class="direction">
                        <checker-item value="开发" class="select">开发</checker-item>
                        <checker-item value="美工" class="select">美工</checker-item>
                    </checker>

                    <div style="padding:15px;" class="join">
                        <x-button class="sign_name" type="primary" @click.native="onSubmit"> 报名</x-button>
                    </div>                        


                </swiper-item>

                <swiper-item class="message"  v-model="form">
                    <search
                    @on-change="getResult"
                    v-model="value"
                    ref="search"
                    @click="onSearchClick(0)"
                    placeholder="输入学号查询"
                    :auto-fixed="autoFixed"></search>
                    
                    <div v-if="show_meg" >
                        <group>
                            <x-input title='姓名:' :readonly="forbid" v-model="student.name"></x-input>
                        </group>
                        <group>
                            <x-input title='班级:' :readonly="forbid" v-model="student.grade"></x-input>
                        </group>
                        <group class="sex">
                            <selector title="性别:" :readonly="forbid" :options="['男','女']" v-model="student.sex"></selector>
                        </group>
                        <group>
                            <x-input title='学号:' :readonly="forbid0" v-model="student.student_id"></x-input>
                        </group>
                        <group>
                            <x-input title='手机号:' :readonly="forbid" v-model="student.phone_num"></x-input>
                        </group>
                        <group>
                            <x-input title='方向:' :readonly="forbid" v-model="student.radio"></x-input>
                        </group>
                        <group class="join" style="margin:0 15px;" v-if="ok">
                            <x-button class="sign_name" type="primary" @click.native="changeMessage">我要修改</x-button>
                        </group>
                        <group class="join" style="margin:0 15px;" v-else>
                            <x-button class="sign_name" type="primary" @click.native="revise">保存修改</x-button>
                        </group>
                    </div>

                </swiper-item>
            </swiper>
        </div>
    </div>


</template>


<style>
    .sex2 .weui-label{
        width: 50px;
    }
    .sex .weui-label{
        width: 3.5em;
    }
    .sex .weui-cell__ft{
        text-align: left !important;
        color: #000;
    }
    .demo2-item {
      width: 40px;
      height: 40px;
      border: 1px solid #ccc;
      display: inline-block;
      border-radius: 50%;
      line-height: 40px;
      text-align: center;
    }
    .demo2-item-selected {
      border-color: green;
    }
   .i_style i:before{
        color: rgb(22,25,94) !important;
    }
    .i_style i{
        color: rgb(22,25,94) !important;
    }
    .weui-search-bar{
        padding: 2px 3px !important;
        height: 40px;
    }
    .weui-search-bar__form,.weui-search-bar__label{
        padding-top: 4px !important;
    }
    .weui-search-bar__cancel-btn{
        padding-top: 4px !important;
        padding-right: 6px;
        color: rgb(22,25,94) !important;
        text-decoration: none;
    }
    .vux-search-box>.weui-cells{
        border: none;
    }
</style>
<style scoped>
    .vux-tab{
        height: 49px;
    }
    .join{
        color: #ffffff;
        text-align: center;
        margin-top: 20px;
    }
    .vux-check-icon{
        margin: 20px ;
        text-align: center;
    }
    .sign_name,.sice[data-v-385fe10e]:hover{
        background-color:rgb(22,25,94);
    }
    .sice,.sice:hover{
        background-color:rgb(22,25,94);
    }
    .join button:active {
        background-color: rgb(22,25,94);
    }
    .weui-search-bar__box{
        padding-top: 4px;
    }
    .direction{
        text-align: center;
    }
    .select{
        margin:20px 30px 0;
    }
    .demo2-item-selected{
        border-color: rgb(22,25,94);
    }
    .message>.vux-x-input{
        border: none;
    }
    .message>.vux-no-group-title{
        border: none !important;
    }
</style>

<script>
    import { Tab, TabItem, Swiper, Selector, SwiperItem,XInput,Group,CheckIcon,XButton,Cell,Search,Checker,CheckerItem } from 'vux'
    export default{
        components:{
            Tab,
            TabItem,
            Swiper,
            SwiperItem,
            XInput,
            Group,
            CheckIcon,
            XButton,
            Cell,
            Search,
            Checker,
            CheckerItem,
            Selector,
        },
        data(){
            return {
                commonList: [ '开发', '美工'],
                list:  ['我要报名', '报名信息'], 
                list2: [{key: '男', value: '男'}, {key: '女', value: '女'}],        
                index: 0,
                demo2: '我要报名',
                demo1: false,
                demo2: true,
                autoFixed: false,
                results: [],
                value: '',

                student: {
                    name        : '李红斌',
                    grade       : '计科163',
                    sex         : '男',
                    phone_num   : '18303612353',
                    student_id  : '20161514325',
                    radio       : '开发',
                    create_time : 0,
                },

                form: {
                    name:       '',
                    grade:      '',
                    sex:        '男',
                    student_id: '',
                    phone_num:  '',
                    radio:      '美工',
                    code:       '',
                },
                time: 0,
                forbid0: true,
                forbid: true,
                forbid2: false,
                ok: true,
                show_meg: true,
            }
        },
        methods: {
            changeMessage(){
                this.forbid = false;
                this.ok = false;
            },
            getResult (val) {
              if(val.length>=11){
                this.onSearchClick (val);
              }else{
                this.show_meg = false;
              }
            },

            remove_spaces(mate){
                mate.name        = mate.name.trim();
                mate.grade       = mate.grade.trim();
                
                mate.sex       = mate.sex.trim();
                mate.student_id  = mate.student_id.trim();
                mate.phone_num   = mate.phone_num.trim();
            },
            test(mate){
                var reg_name    = /^[\u4E00-\u9FA5]{2,4}$/;
                var reg_id      = /^20\d{8,9}$/;
                var reg_mobile  = /^1[3|5|7|8]\d{9}$/;
                var reg_phone    = /^0\d{2,3}-?\d{7,8}$/;

                if(!(reg_name.test(mate.name))){
                    console.log(mate.name)
                    this.$message({
                        showClose: true,
                        message: '姓名错误，请重新填写',
                        type: 'warning'
                    });
                }else if(mate.grade.length < 5 || mate.grade.length > 10){
                    this.$message({
                        showClose: true,
                        message: '班级错误，请重新填写',
                        type: 'warning'
                    });
                }else if(!reg_id.test(mate.student_id)){
                    this.$message({
                        showClose: true,
                        message: '学号错误，请重新填写',
                        type: 'warning'
                    });
                }else if(!reg_mobile.test(mate.phone_num) && !reg_phone.test(mate.phone_num)){
                    this.$message({
                        showClose: true,
                        message: '电话号码错误，请重新填写',
                        type: 'warning'
                    });
                // }else if(mate.code.length !== 6){
                //     this.$message({
                //         showClose: true,
                //         message: '验证码错误',
                //         type: 'warning'
                //     });
                }else {
                    return true;
                }
                return false;
            },
            te(key){
                var reg_id = /^20\d{8,9}$/;
                if(!reg_id.test(key)){
                    this.$message({
                        showClose: true,
                        message: '学号错误，请重新填写',
                        type: 'warning'
                    });
                }else {
                    return true;
                }
                return false;
            },
            onSearchClick (val) {
                var student_id  = val.trim();
                let obj2 = this;
                if(this.te(student_id)){

                    axios.post("wx/search", {
                            student_id : student_id,
                        }).then(function (response) {
                            var data = response.data;
                            if(data.code == 0){
                                obj2.show_meg = true;
                                obj2.student.name       = data.msg.name;
                                obj2.student.grade      = data.msg.class;
                                obj2.student.sex        = data.msg.sex;
                                obj2.student.student_id = data.msg.student_id;
                                obj2.student.phone_num  = data.msg.phone;
                                obj2.student.radio      = data.msg.dretion.toString();
                                // this.reset_direction();
                                // this.student.create_time= data.msg.create_time;
                            } else {
                                obj2.$message({
                                    showClose: true,
                                    message: data.msg,
                                    type: 'error'
                                });
                            }
                        })                    
                }
            },
            onSubmit() {
                var mate = this.form;
                let obj3 = this;
                this.remove_spaces(mate);
                if(this.test(mate)){

                axios.post("wx/sign", {
                        name       : this.form.name,
                        grade      : this.form.grade,
                        sex        : this.form.sex,
                        student_id : this.form.student_id,
                        phone_num  : this.form.phone_num,
                        radio      : this.form.radio,
                        code       : this.form.code,
                    }).then(function (response) {
                        var data = response.data;
                            if(data.code == 0){
                                obj3.$message({
                                    showClose: true,
                                    message: data.msg,
                                    type: 'success',
                                    forbid: true,
                                    ok: true,
                                });
                            } else {
                                obj3.$message({
                                    showClose: true,
                                    message: data.msg,
                                    type: 'error'
                                });
                            }
                });

                }

            },
            revise(){
                var re_mate = this.student;
                this.remove_spaces(re_mate);
                let obj = this;
                if(this.test(re_mate)){

                axios.post("wx/reset", {
                        name       : re_mate.name,
                        grade      : re_mate.grade,
                        sex        : re_mate.sex,
                        student_id : re_mate.student_id,
                        phone_num  : re_mate.phone_num,
                        radio      : re_mate.radio,

                    }).then(function (response) {
                        var data = response.data;
                            if(data.code == 0){
                                obj.$message({
                                    showClose: true,
                                    message: data.msg,
                                    type: 'success',
                                    forbid: true,
                                    ok: true,
                                });
                                obj.forbid = true;
                                obj.ok = true;
                            } else {
                                obj.$message({
                                    showClose: true,
                                    message: data.msg,
                                    type: 'error'
                                });
                            }
                });
                }
            }
        },
    }
</script>
