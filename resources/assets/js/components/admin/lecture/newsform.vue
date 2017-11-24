<template>

    <el-dialog title="视频信息" :visible.sync="dialogFormVisible" :close-on-click-modal="true">

        <el-form :model="lectureMessage">
            <div class="demo-input-size">
                <div class="flexs">
                    <el-form-item label="视频名称" :label-width="formLabelWidth">
                        <el-input v-model="lectureMessage.lecture_theme" auto-complete="off"  size="medium"></el-input>
                    </el-form-item>
                    <el-form-item label="主讲人" :label-width="formLabelWidth">
                        <el-input v-model="lectureMessage.lecture_user" auto-complete="off"  size="medium"></el-input>
                    </el-form-item>
                </div>

                <div class="flexs">
                    <el-form-item label="视频类别" :label-width="formLabelWidth">
                        <el-select v-model="lectureMessage.lecture_sort" placeholder="请选择">
                            <el-option
                                    v-for="item in lecturesort"
                                    :key="item.idmarch_sort"
                                    :label="item.sort_name"
                                    :value="item.idmarch_sort">
                            </el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item label="发布日期" :label-width="formLabelWidth">
                        <div class="block">
                            <el-date-picker
                                    type="date"
                                    placeholder="选择日期"
                                    v-model="lectureMessage.lecture_date"
                                    >
                            </el-date-picker>
                        </div>
                    </el-form-item>
                </div>

                <div class="flexs center">
                    <el-form-item label="视频封面">
                        <el-upload
                                class="avatar-uploader"
                                action="lecture/alterlecture"
                                ref="upload"
                                :show-file-list="false"
                                :auto-upload="false"

                                :on-success="handleAvatarSuccess"
                                :before-upload="beforeAvatarUpload">
                            <img v-if="lectureMessage.lecture_img" :src="lectureMessage.lecture_img" class="avatar">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                    </el-form-item>
                </div>

                <div>
                    <el-form-item label="视频介绍">
                        <el-input
                                type="textarea"
                                :rows="2"
                                placeholder="请输入内容"
                                minlength:5
                                maxlength:50
                                v-model="lectureMessage.lecture_content">
                        </el-input>
                    </el-form-item>
                </div>


            </div>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="cancel">取 消</el-button>
            <el-button type="primary" @click="onsubmit();cancel()" :disabled="bool">确 定</el-button>
        </div>
    </el-dialog>
</template>

<script>
    export default {
        data() {
            return {
                formLabelWidth:'100px',
                bool:true
            }
        },
        methods: {
            cancel() {
                this.$emit('cancel');
            },


            handleAvatarSuccess(res, file) {
                this.imageUrl = URL.createObjectURL(file.raw);
            },
            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isJPG) {
                    this.$message.error('上传头像图片只能是 JPG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return isJPG && isLt2M;
            },
            test() {

                var reg_user = /^[\u4E00-\u9FA5]{2,4}$/;
                var reg_theme = /^[\u4E00-\u9FA5]{2,15}$/;
                var reg_content = /^[\u4E00-\u9FA5]{5,50}$/;


                if(!reg_user.test(this.lectureMessage.lecture_user)) {
                    this.reception_prompt('主讲人格式错误！');
                }
                else if(!reg_theme.test(this.lectureMessage.lecture_theme)) {
                    this.reception_prompt('视频名称格式错误！');
                }
                else if(this.lectureMessage.lecture_sort == '') {
                    this.reception_prompt('请选择视频类别！');
                }
                else if(this.lectureMessage.lecture_date == '') {
                    this.reception_prompt('请选择视频上传时间');
                }
                else if(this.lectureMessage.lecture_img == '') {
                    this.reception_prompt('请选择视频封面，否则将会使用默认');
                }
                else if(!reg_content.test(this.lectureMessage.lecture_content)) {
                    this.reception_prompt('视频简介格式错误！');
                }
                else {
                    return true;
                }

            },
            onsubmit() {
//                if(this.test()) {
//                    this.$refs.upload.submit();
                    axios.post('lecture/alterlecture',{
                        'idmarch_lecture'  :  this.lectureMessage.idmarch_lecture,
                        'lecture_user'     :  this.lectureMessage.lecture_user,
                        'lecture_date'     :  this.getDate(this.lectureMessage.lecture_date),
                        'lecture_content'  :  this.lectureMessage.lecture_content,
                        'lecture_sort'     :  this.lectureMessage.lecture_sort,
                        'lecture_img'      :  this.lectureMessage.lecture_img,
                        'lecture_theme'    :  this.lectureMessage.lecture_theme
                    }).then(res=>{
                        if(res.data.code == 0) {
                            this.$notify({
                                title: '成功',
                                message: res.data.msg,
                                type: 'success',
                                duration:2000
                            });
                        }else {
                            this.$notify.error({
                                title: '错误',
                                message: res.data.msg,
                                duration:2000
                            });
                        }
                    });

//                }
            },
            getDate(str) {
               var date = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/;
               if(date.test(str)) return str;

                var year = str.getFullYear();
                var month = str.getMonth()+1;
                var date = str.getDate();

                return year + '-' + month + '-' + date;

            }


        },
        watch: {
            'lectureMessage' : {
                handler:function (val, oldval) {
                  if(oldval.hasOwnProperty("lecture_user")) {
                      this.bool = false;
                      this.lecturesort.forEach(function (value, index) {
                          if(oldval.lecture_sort == value.sort_name) {
                              oldval.lecture_sort = value.idmarch_sort;
                              return false;
                          }
                      })
                  }
                },
                deep:true
            }

        },
        beforeDestroy:function () {
          console.log("aaaaa");
        },
        props:['dialogFormVisible','lectureMessage','lecturesort']
    }
</script>

<style>

    .flexs .el-form-item__content {
        width:185px !important;
    }
    .el-form-item {
        margin-bottom: 0 !important;
    }
    .flexs {
        display: flex;
    }
    .center {
        justify-content:center;
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
</style>