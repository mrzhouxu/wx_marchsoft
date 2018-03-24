<template>
    <div>
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner">
                <i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>三月后台</el-breadcrumb-item>
                <el-breadcrumb-item>三月介绍</el-breadcrumb-item>
                <el-breadcrumb-item>毕业学子</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <div>
            <el-button type="primary" @click="handleAdd()">新增学子</el-button>
            <el-button type="primary" @click="handleDelete(multipleSelection)">删除选中</el-button>
        </div>

        <el-table ref="multipleTable" :data="userdata" tooltip-effect="dark" style="width: 100%" @selection-change="handleSelectionChange">
            <el-table-column type="selection" width="60">
            </el-table-column>
            <el-table-column prop="user_name" label="姓名" width="120">
            </el-table-column>
            <el-table-column prop="user_sex" label="性别" width="120">
            </el-table-column>
            <el-table-column prop="user_phone" label="联系方式" width="170">
            </el-table-column>
            <el-table-column prop="class" label="班级" width="120">
            </el-table-column>
            <el-table-column prop="department" label="学院" width="140">
            </el-table-column>
            <el-table-column prop="level" label="入学年份" width="120">
            </el-table-column>
            <el-table-column label="操作">
                <template slot-scope="scope">
                    <i class="el-icon-edit" @click="handleEdit(scope.$index, scope.row)"></i>
                    <i class="el-icon-delete" @click="handleDelete(multipleSelection)"></i>
                </template>
            </el-table-column>
        </el-table>

        <div class="block">
            <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page="currentPage" :page-sizes="pageSizes" :page-size="number" layout="total, sizes, prev, pager, next, jumper" :total="totalNumber">
            </el-pagination>
        </div>

        <el-dialog title="个人信息" :visible.sync="dialogFormVisible" @close="close">
            <el-form :model="userMessage">
                <el-form-item label="姓名" :label-width="formLabelWidth">
                    <el-input v-model="userMessage.user_name" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="性别" :label-width="formLabelWidth">
                    <el-select v-model="userMessage.user_sex" clearable placeholder="请选择">
                        <el-option label="男" value="男"></el-option>
                        <el-option label="女" value="女"></el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="入学年份" :label-width="formLabelWidth">
                    <!-- <el-autocomplete
                        class="inline-input"
                        v-model="state1"
                        :fetch-suggestions="querySearch"
                        placeholder="请输入内容"
                        @select="handleSelect">
                    </el-autocomplete> -->

                    <el-input v-model="userMessage.level" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="班级" :label-width="formLabelWidth">
                    <el-input v-model="userMessage.class" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="联系方式" :label-width="formLabelWidth" v-show="dialogFormNewVisible">
                    <el-input v-model="userMessage.user_phone" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="学院" :label-width="formLabelWidth">
                    <el-input v-model="userMessage.department" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="头像">
                    <el-upload name="img" class="avatar-uploader" action="" :show-file-list="false" ref="imges" :before-upload="beforeUpload" :data="csrf_token">
                        <img v-if="imageUrl" :src="imageUrl" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
                    </el-upload>
                </el-form-item>

                <el-form-item>
                    <el-input type="textarea" :rows="2" placeholder="请输入内容" v-model="userMessage.describe">
                    </el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="cancelDialog()">取 消</el-button>
                <el-button type="primary" @click="onSubmit()">确 定</el-button>
            </div>
        </el-dialog>

    </div>
</template>

<script>
export default {
    data() {
        return {
            page: 0,
            number: 10,
            currentPage: 1,
            dialogFormVisible: false,
            dialogFormNewVisible: false,
            pageSizes: [5, 10, 15, 20],
            totalNumber: 0,
            userMessage: {},
            imageUrl: '',
            userdata: [],
            formLabelWidth: '120px',
            formData: new FormData(),

            multipleSelection: [],
            csrf_token: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }
    },
    methods: {
        getData() {
            axios.get('/userinfo/getuserdata', {
                params: {
                    'page': this.page,
                    'number': this.number
                }
            }).then(res => {
                this.userdata = res.data.result;
                console.log(this.userdata);
            });
            axios.get('/userinfo/getusernum').then(res => {
                if (res.data.code == 0) {
                    this.totalNumber = res.data.result;
                }
            })
        },
        handleSelectionChange(val) {
            this.multipleSelection = val;
            console.log(this.multipleSelection);
        },
        handleSizeChange(val) {
            if (this.number != val) {
                this.number = val;
                this.getData();
            }
            console.log(`每页 ${val} 条`);
        },
        handleCurrentChange(val) {
            let valmore = val - 1;
            if (this.page != valmore) {
                this.page = valmore;
                this.getData();
            }
            console.log(`当前页: ${val}`);
        },
        handleEdit(row, val) {
            console.log(val);
            this.userMessage = val;
            if (val.avator != null) this.imageUrl = val.avator;
            this.dialogFormVisible = true;
        },
        cancelDialog() {
            this.dialogFormVisible = false;
            this.userMessage = {};
            this.imageUrl = '';
        },
        beforeUpload(file) {
            const isJPG = file.type === 'image/jpeg';
            const isLt2M = file.size / 1024 / 1024 < 2;
            console.log(file);

            if (!isJPG) {
                this.$message.error('上传头像图片只能是 JPG 格式!');
                return false;
            }
            if (!isLt2M) {
                this.$message.error('上传头像图片大小不能超过 2MB!');
                return false;
            }
            this.userMessage.avator = file;
            this.formData.append('avator', file);

            this.imageUrl = URL.createObjectURL(file);
            return false;
        },
        test() {

        },
        //注意FormData和axios.post当中的data不能同是发送
        onSubmit() {
            if (!this.dialogFormNewVisible)
                this.updateUser();
            else
                this.addUser();
        },
        addMessage() {
            for (var key in this.userMessage) {
                if (key == 'avator' && !(Object.prototype.toString.call(this.userMessage[key]) === "[object String]")) continue;
                this.formData.append(key, this.userMessage[key]);
            }
        },
        updateUser() {

            this.addMessage();
            this.postUserData('/userinfo/updateuser', this.formData);
        },
        addUser() {
            this.addMessage();
            this.postUserData('/userinfo/adduser',this.formData);
        },
        /**
         * postUserData用于提交数据
         * url 提交数据的地址
         * data 用于提交的数据
         */
        postUserData(url, data) {
            axios.post(url, data).then(res => {
                if (res.data.code == 0) {
                    this.$notify({
                        title: '成功',
                        message: res.data.msg,
                        type: 'success',
                        duration: 2000
                    });
                } else {
                    this.$notify({
                        title: '失败',
                        message: res.data.msg,
                        type: 'error',
                        duration: 2000
                    });
                }
                this.dialogFormVisible = false;
                this.userMessage = {};
            });
        },

        handleDelete(rows) {

            this.$confirm('此操作将删除选中文件, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                if (rows.length < 1) this.reception_prompt('未选中所要删除的行!');
                let userPhone = [];
                rows.forEach(function (value, index) {
                    userPhone.push(value.user_phone);
                });
                axios.post('/userinfo/deleteusers', userPhone).then(res => {
                    if (res.data.code == 0) {
                        this.$notify({
                            title: '成功',
                            message: res.data.msg,
                            type: 'success',
                            duration: 2000
                        });
                    } else {
                        this.$notify({
                            title: '失败',
                            message: res.data.msg,
                            type: 'error',
                            duration: 2000
                        });
                    }
                })
                // this.$message({
                //     type: 'success',
                //     message: '删除成功!'
                // });
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消删除'
                });
            })

        },
        handleAdd() {
            this.dialogFormVisible = true;
            this.dialogFormNewVisible = true;
        },
        close() {
            this.userMessage = {}
            this.dialogFormVisible = false;
            this.dialogFormNewVisible = false;
        }


    },
    created() {
        this.getData();
    },
    components: {

    }
}

</script>

<style>
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.avatar-uploader .el-upload:hover {
  border-color: #409eff;
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
