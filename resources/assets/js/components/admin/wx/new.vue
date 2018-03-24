<template>

    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb separator-class="el-icon-arrow-right">
                <el-breadcrumb-item>三月新闻</el-breadcrumb-item>
                <el-breadcrumb-item>新闻列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div style="width: 100%; margin-top: 20px;" v-loading="loading">
            <el-table
                    ref="multipleTable"
                    :data="tableData3"
                    tooltip-effect="dark"
                    style="width: 100%"
                    @selection-change="handleSelectionChange">
                <el-table-column
                        type="selection"
                        width="55">
                </el-table-column>
                <el-table-column
                        prop="news_title"
                        label="标题"
                        width="300">
                </el-table-column>
                <el-table-column
                        prop="news_publisher"
                        label="作者"
                        width="200">
                    <!---->
                </el-table-column>
                <el-table-column
                        prop="news_date"
                        label="日期"
                        width="300">
                </el-table-column>
                <el-table-column label="浏览量" width="200" prop="news_num">

                </el-table-column>
                <el-table-column label="操作">
                    <template slot-scope="scope">
                        <el-button size="mini"
                                   @click="handleEdit(scope.$index, scope.row)">
                            <i class="el-icon-edit"></i>
                        </el-button>
                        <el-button size="mini" type="danger"
                                   @click="handleDelete(scope.$index, scope.row)">
                            <i class="el-icon-delete"></i>
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
            <el-button type="primary" @click="deleteItems()">删除所选</el-button>
        </div>

        <div style="width: 381px;margin-top: 20px;">
            <el-pagination
                    @current-change="handleCurrentChange"
                    :current-page.sync="currentPage1"
                    :page-size="10"
                    layout="prev, pager, next, jumper"
                    :total="total">
            </el-pagination>
        </div>
    </div>
</template>
<style>
    #graph-container {
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        position: absolute;
        background-color: #455660;
    }
    .sigma-edge {
        stroke: #14191C;
    }
    .sigma-node {
        fill: green;
        stroke: #14191C;
        stroke-width: 2px;
    }
    .sigma-node:hover {
        fill: blue;
    }
    .muted {
        fill-opacity: 0.1;
        stroke-opacity: 0.1;
    }
</style>

<script>
    export default {
        components: {},
        data() {
            return {
                tableData3: [],
                multipleSelection: [],
                total: 0,
                loading: true,
                currentPage1: 0,
                deleteItem:[]

            }
        },
        methods: {
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
                this.multipleSelection = val;
                this.deleteItem = val;
                console.log(this.deleteItem)
            },
            handleCurrentChange(val) {
                this.loading = true
                axios.get('News/getNewItem?page=' + val).then(res => {
                    this.loading = false
                    this.tableData3 = res.data.result.data;
                    this.total = res.data.result.total;
                })
            },
            handleEdit(index, row){
                this.$router.push({name:"添加新闻",params: { newId: this.tableData3[index].idmarch_news }})
            },

            handleDelete(index, row) {
                this.loading = true;
                axios.post('News/delete', {
                    id: this.tableData3[index].idmarch_news
                }).then(res => {
                    if (res.data.code == 0) {
                        this.handleCurrentChange(this.currentPage1)
                        this.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                    } else {
                        this.$message.error('删除失败');
                    }
                })

            },
            deleteItems(){
                let id = [];
                for(var i = 0;i<this.deleteItem.length;i++){
                    id[i] = this.deleteItem[i].idmarch_news;
                }
                axios.post('News/delete', {
                    id: id
                }).then(res => {
                    if (res.data.code == 0) {
                        this.handleCurrentChange(this.currentPage1)
                        this.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                    } else {
                        this.$message.error('删除失败');
                    }
                })
//
            }
        },
        created: function () {
            axios.get('News/getNewItem').then(res => {

                if (res.data.code == 0) {
                    this.loading = false
                    this.tableData3 = res.data.result.data;
                    this.total = res.data.result.total;
                }
            })
        },
        mounted() {

        }
    }
</script>
