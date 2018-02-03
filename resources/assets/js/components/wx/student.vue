<template>
    <div>
        <div style="width: 100%;height: 50px;background-color: #4d93db">
            <p style="width: 80px;height: 20px;margin: 18px 0 0 0;font-size: 13px;text-align: center;color: white;float: left">
                毕业学子</p>
            <p style="width: 80px;margin: 0 auto;height: 20px;padding: 15px 0;font-size: 15px;text-align: center;color: white">
                三月软件</p>
        </div>
        <panel  :list="list" :type="type" :footer="footer"  @on-click-footer="onFooterClick()"></panel>
    </div>
</template>
<script>
    import { Panel } from 'vux'

    export default {
        components: {
            Panel
        },
        data() {
            return {
                page:1,
                type: '1',
                list: [],
                footer: {
                    title: '加载更多',
                },
            }

        },
        methods: {
            onFooterClick(){
                this.page++;
                axios.get('/student/getStudents?page='+this.page).then(res=>{
                    if(res.data.code == 0){
                        let copyList = this.list;
                        this.resetList();
                        for(let i in copyList){
                            this.initList(i)
                            this.list[i].src = copyList[i].src;
                            this.list[i].fallbackSrc = copyList[i].fallbackSrc
                            this.list[i].title = copyList[i].title
                            this.list[i].desc = copyList[i].desc
                            this.list[i].url = copyList[i].url
                        }
                        let lenght = copyList.length;
                        lenght = parseInt(lenght);
                        this.setAnyone(res.data.result,lenght)
                        console.log(res.data.result)
                    }
                })
            },
            initList(i){
                this.list[i]={
                    src:'',
                    fallbackSrc:'',
                    title:'',
                    desc:'',
                    url:''
                }
            },
            setList(i,arc){
                if(arc.avator!="" && arc.avator!=null)
                    this.list[i].src = 'http://www.marchsoft.cn/Common/img/photo/photo/m_'+arc.avator;
                else
                    this.list[i].src='/img/student/m_fengmian.jpg'
                this.list[i].fallbackSrc='http://placeholder.qiniudn.com/60x60/3cc51f/ffffff';
                this.list[i].title = arc.user_name;
                if(arc.describe == "" || arc.describe == null){
                    this.list[i].desc="暂无此人介绍，敬请期待。"
                }else{
                    this.list[i].desc = arc.describe;
                }
                this.list[i].url = '/getStudent/'+arc.iduser_info;
            },
            resetList(){
                this.list=[{
                    src:'',
                    fallbackSrc:'',
                    title:'',
                    desc:'',
                    url:''
                }]
            },
            setAnyone(arr,j){

                for(let i in arr){
                    this.initList(parseInt(i)+j);
                    this.setList(parseInt(i)+j,arr[i])
                }
            }
        },
        mounted:function () {
            axios.get('/student/getStudents?page='+this.page).then(res=>{
                console.log(res.data.result[0].user_name)
                if(res.data.code == 0){
                    this.resetList();
                    this.setAnyone(res.data.result,0)
                }
            })
        }
    }
</script>
<style>
    *{
        margin: 0;
        padding: 0;
    }
    .weui-media-box{
        text-decoration: none;
    }
    a{
        text-decoration: none;
        color: #999999;
    }
    a:active{
        color: #999999;
    }
</style>