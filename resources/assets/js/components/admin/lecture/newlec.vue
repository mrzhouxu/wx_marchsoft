<template>
    <el-form ref="form" :model="form" label-width="80px" >
        <div class="flexs center marbotom">
            <el-form-item label="视频名称">
                <el-input placeholder="视频名称" v-model.trim="form.lecture_theme"></el-input>
            </el-form-item>
            <el-form-item label="讲课人">
                <!--<el-input placeholder="讲课人"></el-input>-->
                <el-autocomplete
                        class="inline-input"
                        v-model.trim="form.lecture_user"
                        :fetch-suggestions="querySearch"
                        placeholder="请输入内容"
                        @select="handleSelect"
                ></el-autocomplete>
            </el-form-item>
        </div>
        <div class="flexs center marbotom">
            <el-form-item label="视频类别">
                <el-select v-model="form.lecture_sort" placeholder="请选择">
                    <el-option
                            v-for="item in sorts"
                            :key="item.idmarch_sort"
                            :label="item.sort_name"
                            :value="item.idmarch_sort">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="上传日期">
                <div class="block">
                    <el-date-picker
                            v-model="form.lecture_date"
                            type="date"
                            placeholder="选择日期">
                    </el-date-picker>
                </div>
            </el-form-item>
        </div>
        <div class="flex center marbotom handered">
            <el-form-item label="视频简介">
                <el-input
                        type="textarea"
                        :rows="3"
                        placeholder="请输入内容"
                        v-model.trim="form.lecture_content">
                </el-input>
            </el-form-item>
        </div>
        <div class="flex center marbotom handered">
            <el-form-item label="视频地址">
                <el-input placeholder="请输入内容" v-model.trim="form.lecture_file">
                    <template slot="prepend">http://</template>
                </el-input>
            </el-form-item>
        </div>
        <div class="flexs center">
            <el-form-item label="视频封面">
                <el-upload
                        name="img"
                        class="avatar-uploader"
                        action="lecture/newlecture"
                        :show-file-list="false"
                        ref="imges"
                        :http-request="uploadImg"
                        :data="csrf_token"
>
                    <img v-if="imageUrl" :src="imageUrl" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
                </el-upload>
            </el-form-item>

            <!--:auto-upload="false"-->
            <!--:show-file-list="false"-->
            <!--:on-success="handleAvatarSuccess"-->
            <!--:before-upload="beforeAvatarUpload"-->

            <!--<el-form-item label="上传视频">-->
                <!--<el-upload-->
                        <!--name="video"-->
                        <!--class="upload-demo"-->
                        <!--drag-->
                        <!--ref="upload"-->
                        <!--:auto-upload="false"-->
                        <!--:data="csrf_token"-->
                        <!--action="lecture/newlecture"-->
                        <!--:show-file-list="true"-->
                        <!--:before-upload="beforeAvatarUpload"-->
                        <!--multiple>-->
                    <!--<i class="el-icon-upload"></i>-->
                    <!--<div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>-->
                    <!--<div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过500kb</div>-->
                <!--</el-upload>-->
            <!--</el-form-item>-->
        </div>
        <div class="flexs right buttons">
           <el-form-item class=" flexs right">
               <el-button type="warning">清空<i class="el-icon-close el-icon--right"></i></el-button>
               <el-button type="primary" @click="onSubmit">上传<i class="el-icon-upload el-icon--right"></i></el-button>
           </el-form-item>
        </div>
    </el-form>
</template>

<script>
    export default {
        data() {
            return {
                form:{
                    lecture_user:'',
                    lecture_date:'',
                    lecture_content:'',
                    lecture_sort:'',
//                    lecture_img:'',
                    lecture_theme:'',
                    lecture_file:''
                },
                formLabelWidth:'200px',
                imageUrl:'',
                sorts:[],
                input3:'',

                restaurants:[],
                csrf_token: {
                    _token:window.axios.defaults.headers.common['X-CSRF-TOKEN']
                }
            }
        },
        methods: {
            uploadImg(file) {
//                console.log(file);
                this.beforeAvatarUpload(file);
            },
            handleAvatarSuccess(res, file) {
                this.imageUrl = URL.createObjectURL(file.raw);
            },
            beforeAvatarUpload(file) {

                const isJPG = file.file.type === 'image/jpeg';
                const isLt2M = file.file.size / 1024 / 1024 < 2;
                console.log(isLt2M);

                if (!isJPG) {
                    this.$message.error('上传头像图片只能是 JPG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                this.imageUrl = URL.createObjectURL(file);
                return isJPG && isLt2M;
            },

            querySearch(queryString, cb) {

                var restaurants = this.restaurants;
                var results = queryString ? restaurants.filter(this.createFilter(queryString)) : restaurants;
//                console.log(cb(results));
                // 调用 callback 返回建议列表的数据
                cb(results);
            },
            createFilter(queryString) {
                return (restaurant) => {
                    return (restaurant.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
                };
            },
            handleSelect(item) {
                console.log(item);
            },
            test() {
                var reg_user = /^[\u4E00-\u9FA5]{2,4}$/;
                if(this.form.lecture_theme.length<=1 || this.form.lecture_theme.length>15)
                    this.reception_prompt('请规范视频名称的字数！');
                else if(this.form.lecture_user.length<=1 ||this.form.lecture_user.length>6)
                    this.reception_prompt('请规范讲课人的字数！');
                else if(!reg_user.test(this.form.lecture_user))
                    this.reception_prompt('讲课人格式不规范！');
                else if(this.form.lecture_sort == '')
                    this.reception_prompt('请选择视频类别！');
                else if(this.form.lecture_date == '')
                    this.reception_prompt('请选择视频上传日期！');
                else if(this.form.lecture_content.length<=1 || this.form.lecture_content.length>50)
                    this.reception_prompt('请规范视频简介的字数！');
                else if(this.imageUrl == '')
                    this.reception_prompt('请选择视频封面！');
                else
                    return true;
            },
            onSubmit() {
//                if(this.test()) {
                        this.$refs.imges.submit();
                        axios.post('lecture/newlecture',{
                            'lecture_theme' : this.form.lecture_theme,
                            'lecture_user' :this.form.lecture_user,
                            'lecture_date':this.form.lecture_date,
                            'lecture_sort':this.form.lecture_sort,
                            'lecture_content':this.form.lecture_content
                        })
//                }


            }

        },
        created() {
            axios.get('lecture/getlectuesort').then(res=>{
                if(res.data.code == 0) {
                    this.sorts = res.data.result;
                }
            });

        },
        mounted() {
            axios.get('lecture/getusers').then(res=>{
                if(res.data.code == 0) {
                    this.restaurants = res.data.result;
                    this.restaurants.forEach(function (item, index) {
                        item.value = item.lecture_user;
                    })
                }
            });
        }

    }
</script>

<style>
    .flexs{
        display: flex;
    }
    .center {
        justify-content:center;
    }
    .el-form-item {
        width:50% !important;
    }
    .wid {
        width:90%;
    }
    .el-select {
        width: 100% !important;
    }
    .el-input {
        width: 100% !important;
    }
    .buttons .el-form-item__content {
        margin-left:15px !important;
    }
    .inline-input {
        width: 100% !important;
    }
    .marbotom {
        margin-bottom: 2%;
    }
    .handered .el-form-item {
        width: 100% !important;
    }
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
    .right {
        flex-direction:row-reverse
    }

</style>