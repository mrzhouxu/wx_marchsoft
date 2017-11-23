<template>
    <div>
        <div>
            <tab :line-width=2 active-color='rgb(22,25,94)' v-model="index" >
                <tab-item class="vux-center" :selected="demo2 === item" v-for="(item, index) in list" @click="demo2 = item" :key="index">{{item}}
                </tab-item>
            </tab>

            <swiper height="500px" :show-dots="false">
                <swiper-item v-model="form">
                    <group>
                        <x-input title="姓名" v-model="form.name" name="userName" placeholder="请输入姓名" is-type="china-name"></x-input>
                    </group>
                    <group>
                        <x-input title="班级" v-model="form.grade" name="userClass" placeholder="请输入班级"></x-input>
                    </group>
                    <group>
                        <x-input title="学号" v-model="form.student_id" name="userNumber" placeholder="请输入学号"></x-input>
                    </group>
                    <group>
                        <x-input title="手机号码" v-model="form.phone_num" name="mobile" placeholder="请输入手机号码" keyboard="number" is-type="china-mobile"></x-input>
                    </group>
                    <group>
                        <x-input title="发送验证码" class="weui-vcode">
                            <x-button class="sice" slot="right" type="primary" mini>发送验证码</x-button>
                        </x-input>
                    </group>
                    <checker v-model="form.radio" default-item-class="demo2-item" selected-item-class="demo2-item-selected">
                        <checker-item value="1">开发</checker-item>
                        <checker-item value="2">美工</checker-item>
                    </checker>
                    <!-- <check-icon class="i_style" :value.sync="demo1">开发</check-icon>
                    <check-icon class="i_style" :value.sync="demo2">美工</check-icon> -->

                    <div style="padding:15px;" class="join">
                        <x-button class="sign_name" type="primary" @click.native="onSubmit"> 报名</x-button>
                    </div>

                </swiper-item>

                <swiper-item>
                    <!-- <x-input title="美食" v-model="value"></x-input> -->
                    <search
                    @on-change="getResult"
                    :results="results"
                    v-model="value"
                    ref="search"></search>
                    <!-- <div style="padding:15px;">
                        <x-button @click.native="setFocus" type="primary">set focus</x-button>
                    </div> -->
                    <!-- <group>
                        <cell title="static position demo" is-link link="/component/search-static"></cell>
                    </group> -->
                </swiper-item>
            </swiper>
        </div>
    </div>


</template>

<script>
    import { Tab, TabItem, Swiper, SwiperItem,XInput,Group,CheckIcon,XButton,Cell,Search,Checker,CheckerItem } from 'vux'
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
            CheckerItem
        },
        data(){
            return {
                commonList: [ '开发', '美工'],
                list:  ['我要报名', '报名信息'],         
                index: 0,
                demo2: '我要报名',
                demo1: false,
                demo2: true,
                results: [],
                value: '20161514325',

                form: {
                    name:       '',
                    grade:      '',
                    student_id: '',
                    phone_num:  '',
                    radio:      '1',
                    code:       '',
                },
                time: 0,
                disabled: false
            }
        },
        methods: {
            change (val, label) {
              console.log('change', val, label)
            },
            selectFirst () {
              this.checklist001 = ['China']
            },
            selectFirstTwo () {
              this.checklist001 = ['China', 'Japan']
            },
            selectLeft () {
              const left = _.without.apply(_, [this.commonList].concat(this.checklist001))
              this.checklist001 = left
            },
            getResult (val) {
              console.log('on-change', val)
              this.results = val ? getResult(this.value) : []
            },

            remove_spaces(){
                this.form.name        = this.form.name.trim();
                this.form.grade       = this.form.grade.trim();
                this.form.student_id  = this.form.student_id.trim();
                this.form.phone_num   = this.form.phone_num.trim();
                this.form.code        = this.form.code.trim();
            },
            test(){
                var reg_name    = /^[\u4E00-\u9FA5]{2,4}$/;
                var reg_id      = /^20\d{8,9}$/;
                var reg_mobile  = /^1[3|5|7|8]\d{9}$/;
                var reg_phone    = /^0\d{2,3}-?\d{7,8}$/;

                if(!(reg_name.test(this.form.name))){
                    this.$message({
                        showClose: true,
                        message: '姓名错误，请重新填写',
                        type: 'warning'
                    });
                }else if(this.form.grade.length < 5 || this.form.grade.length > 10){
                    this.$message({
                        showClose: true,
                        message: '班级错误，请重新填写',
                        type: 'warning'
                    });
                }else if(!reg_id.test(this.form.student_id)){
                    this.$message({
                        showClose: true,
                        message: '学号错误，请重新填写',
                        type: 'warning'
                    });
                }else if(!reg_mobile.test(this.form.phone_num) && !reg_phone.test(this.form.phone_num)){
                    this.$message({
                        showClose: true,
                        message: '电话号码错误，请重新填写',
                        type: 'warning'
                    });
                }else if(this.form.code.length !== 6){
                    this.$message({
                        showClose: true,
                        message: '验证码错误',
                        type: 'warning'
                    });
                }else {
                    return true;
                }
                return false;
            },
            onSubmit() {
                this.remove_spaces();
                if(this.test()){
                    console.log('asdfasd')
                    // this.$http.post('/sign',{
                    //     name       : this.form.name,
                    //     grade      : this.form.grade,
                    //     student_id : this.form.student_id,
                    //     phone_num  : this.form.phone_num,
                    //     radio      : this.form.radio,
                    //     code       : this.form.radio,
                    // }).then(
                    //     function (response) {
                    //         var data = response.data;
                    //         if(data.code == 0){
                    //             this.$message({
                    //                 showClose: true,
                    //                 message: data.msg,
                    //                 type: 'success'
                    //             });
                    //         } else {
                    //             this.$message({
                    //                 showClose: true,
                    //                 message: data.msg,
                    //                 type: 'error'
                    //             });
                    //         }
                    //     }
                    // )
                }
            }
        },
    }

    function getResult (val) {
      let rs = []
      for (let i = 0; i < 20; i++) {
        rs.push({
          title: `${val} result: ${i + 1} `,
          other: i
        })
      }
      return rs
    }
</script>

<style>
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
    .weui-cells{
        border: 1px solid #d7e7f3 !important;
        border-radius: 5px;
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
    .vux-tab-item{
        line-height: 49px !important;
    }
    .vux-slider{
        padding: 10px 30px !important;
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
    .weui-search-bar__box{
        padding-top: 4px;
    }

</style>