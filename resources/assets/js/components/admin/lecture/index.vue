<template>
    <div>
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>三月后台</el-breadcrumb-item>
                <el-breadcrumb-item>三月课堂</el-breadcrumb-item>
                <el-breadcrumb-item>讲课列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <div>
            <el-button type="primary">下载</el-button>
            <el-button type="primary" @click="handleDelete(multipleSelection)">删除</el-button>
        </div>

        <el-table
                ref="multipleTable"
                :data="lectureAll"
                tooltip-effect="dark"
                style="width: 100%"
                @selection-change="handleSelectionChange"
                highlight-current-row
        >
            <el-table-column
                    type="selection"
                    width="55">
            </el-table-column>
            <el-table-column

                    label="名称"
                    show-overflow-tooltip
            >
                <template slot-scope="scope">
                    <a @click="seeLecture(scope.row.lecture_file)" >{{ scope.row.lecture_theme }}</a>
                </template>
            </el-table-column>
            <el-table-column
                    prop="lecture_user"
                    label="姓名"
                    width="120">
            </el-table-column>
            <el-table-column
                    prop="lecture_sort"
                    label="类型"
                    width="120">
            </el-table-column>
            <el-table-column
                    label="日期"
                    width="120">
                <template slot-scope="scope">{{ scope.row.lecture_date }}</template>
            </el-table-column>


            <el-table-column label="操作">
                <template slot-scope="scope">
                    <i class="el-icon-edit" @click="handleEdit(scope.$index, scope.row)"></i>
                    <i class="el-icon-share"></i>
                    <el-popover
                            ref="popover4"
                            placement="bottom"
                            width="50"
                            trigger="click">
                        <p><a>下载</a></p>
                        <p><a @click="handleDelete(scope.row.idmarch_lecture)">删除</a></p>

                    </el-popover>

                    <i class="el-icon-more" v-popover:popover4></i>
                </template>

            </el-table-column>
        </el-table>


        <div class="block">
            <el-pagination
                    @current-change="handleCurrentChange"
                    :current-page.sync="currentPage1"
                    :page-size="number"
                    layout="total, prev, pager, next"
                    :total="count"
                    v-loading.fullscreen.lock="fullscreenLoading">
            </el-pagination>
        </div>

        <news-Form
                :dialogFormVisible="dialogFormVisible"
                :lectureMessage="lectureMessage"
                :lecturesort="sorts"
                @cancel="change">
        </news-Form>

        <see-lecture
        :dialogSeeLecture="dialogSeeLecture"
        :fileAddress="file">
        </see-lecture>

    </div>
</template>

<script>
    import newsForm from './newsform.vue'
    import seeLecture from './seelec.vue'
    export default {
        data() {
            return {
                currentPage1: 1,
                multipleSelection: [],
                lectureAll:[],
                page:0,
                number:10,
                count:0,
                dialogFormVisible:false,
                dialogSeeLecture:false,
                lectureMessage:{},
                sorts:[],
                file:'',
                fullscreenLoading:false
            }
        },

        methods: {
            seeLecture(file) {
                this.dialogSeeLecture = !this.dialogSeeLecture;
                this.file = file;

            },
            change() {
                this.dialogFormVisible = !this.dialogFormVisible;
            },
            toggleSelection(rows) {
                if (rows) {
                    rows.forEach(row => {
                        this.$refs.multipleTable.toggleRowSelection(row);
                    });
                } else {
                    this.$refs.multipleTable.clearSelection();
                }
            },
            handleSelectionChange(val) {
                var arr = [];
                val.forEach(function (item,index) {
                    arr[index] = item.idmarch_lecture;
                })
                this.multipleSelection = arr;
            },
            handleEdit(index, row) {
//                console.log('aaa');
                this.change();
                this.lectureMessage = row;
            },
            handleCurrentChange(val) {
               this.page = val-1;
                this.fullscreenLoading = true;
                this.fullscreenLoading = true;
                setTimeout(() => {
                    this.fullscreenLoading = false;
                }, 1100);

               this.sendPage();

            },
            handleDelete(row) {
                console.log(row);
                this.$confirm('此操作将永久删除该文件, 是否继续?','提示',{
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(()=>{
                    axios.get('lecture/delete',{
                        'idmarch_lecture' : row
                    }).then(res=>{
                        if(res.data.code == 0) {
                            this.$notify({
                                title: '成功',
                                message: res.data.msg,
                                type: 'success',
                                duration:2000
                            });
                        }
                        else {
                            this.$notify.error({
                                title: '错误',
                                message: res.data.msg,
                                duration:2000
                            });
                        }
                    });
                })

            },
            sendPage() {

                axios.get('lecture/getlecture',{
                    params:{
                        'page': this.page,
                        'number':this.number
                    }
                }).then(res=>{
                    if(res.data.code == 0) {
                       var sorts = this.sorts;
                        res.data.result.forEach(function (item, index) {
                            for(var i=0;i<sorts.length;i++) {

                                if(item.lecture_sort == sorts[i]['idmarch_sort']) {
                                    item.lecture_sort = sorts[i]['sort_name'];
                                }
                            }
                        });

                        this.lectureAll = res.data.result;
//                        console.log(res.data.result);
                    }
                })
            }
        },
        created() {
            axios.get('lecture/getlecturecount').then(res=>{
                if(res.data.code == 0) {
                    this.count = res.data.result;
                }
            });

            axios.get('lecture/getlectuesort').then(res=>{
                if(res.data.code == 0) {
                    this.sorts = res.data.result;
//                    console.log(this.sorts);
                }
            });
            this.sendPage();

        },
        components:{
            newsForm,
            seeLecture
        }

    }



</script>

<style>

</style>