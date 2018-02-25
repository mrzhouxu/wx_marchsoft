<template>
    <div>
        <x-header title="每周一练" ></x-header>
        <div style="background-color:yellow;text-align:center;">
            <x-img :src="img_url" class="ximg-demo" error-class="ximg-error" ></x-img>
        </div>
        <group>
            <group-title slot="title" style="text-align:center; font-size: 23px;color: #000;">{{tk}}
              <x-button style="float:right;" mini plain  @click.native="returnLayout">{{historyAlgorithm}}</x-button>
            </group-title>
            <x-table :cell-bordered="false" style="background-color:#fff;">
              <thead>
                <tr>
                  <th>试题名称</th>
                  <th>关键字</th>
                  <th>发表日期</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in items" @click="openalgorithm(item.id)">
                  <td> {{ item.title }}</td>
                  <td> {{ item.type }}</td>
                  <td>{{ item.time.substr(0,10) }}</td>
                </tr>
              </tbody>
            </x-table>
        </group>
    </div> 
</template>


<script>
    import {XHeader,XImg,Group,GroupTitle,Cell,XTable,XButton} from 'vux'
    export default {
      components:{
          XHeader,  
          XImg,
          Group,
          GroupTitle,
          Cell,
          XTable,
          XButton
      },
      data(){
          return {
             img_url : '/img/mzyl.jpg',
             tk:"题库",
             algorithmlist:"fdsfs",
             historyAlgorithm:"返回",
             items: []
          }
      },
      computed: {},
      methods: {
          openalgorithm(id){
            this.$router.push("/detailedAlgorithms/"+id);
          },
          allalgorithm(){
            var self =this;
                axios.post('wx/algorithm/selectAllPractice').then(function (res) {
                    self.items=res.data.result;
                })
          },
          returnLayout(){
            this.$router.push("/algorithms");
          }
      },
      mounted() {
        this.allalgorithm();
      },
    }
</script>
<style>

table{
  table-layout:fixed;
  word-break:break-all;
}

table tr{
color:blue;
max-height:52px;
}

.ximg-demo {
    width: 100%;
    height: auto;
}

.ximg-error {
  background-color: yellow;
}
</style>