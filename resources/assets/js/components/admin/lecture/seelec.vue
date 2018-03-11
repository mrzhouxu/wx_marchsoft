<template>
    <el-dialog title="视频播放" :visible.sync="dialogSeeLecture" :close-on-click-modal="false" class="see">

        <div class="modal-body">
            <embed quality="high"
                   width="100%"
                   height="400"
                   align="middle"
                   allowscriptaccess="allways"
                   allowfullscreen="true"
                   mode="transparent"
                   type="application/x-shockwave-flash"
                   :src="fileAddress">
        </div>

    </el-dialog>
</template>

<script>
    export default {
        data() {
            return {}
        },
        methods: {},
        props:['dialogSeeLecture','fileAddress']
    }
</script>

<style>
    .see .el-dialog__body {
        padding: 15px 0 !important;
    }
</style>