<template>
    <div>
        <x-header title="每周一练" ></x-header>
        <div style="background-color:yellow;text-align:center;">
            <x-img :src="img_url" class="ximg-demo" error-class="ximg-error" ></x-img>
        </div>
        <group >
            <group-title slot="title">{{newExercises}}<x-button style="float:right;" mini plain  @click.native="HistoryExercises">{{historyAlgorithm}}</x-button></group-title>
            <cell 
                primary="content"
                value-align="left"
                >
                   <div v-html="algorithmtitle"></div>
                </cell>
            <divider>{{ Algorithmtitme}}</divider>
            <cell
              :title="algorithmButton"
              is-link
              :border-intent="false"
              :arrow-direction="showContent ? 'up' : 'down'"
              @click.native="showContent = !showContent">
            </cell>
              <div class="slide" :class="showContent?'animate':''"  v-html="algorithmAnswer">
              </div>
        </group>
    </div> 
</template>

<script>
    import {XHeader,XImg,Group,Cell,GroupTitle,Divider,XButton } from 'vux'
    export default {
		components:{
            XHeader,
            XImg,
            Group,
            GroupTitle,
            Cell,
            Divider,
            XButton
        },
        data(){
            return {
                newExercises:"题目",
                algorithmtitle:"",
                algorithmButton:"查看答案",
                algorithmAnswer:"",
                historyAlgorithm:"返回",
                Algorithmtitme:"0",
                img_url : '/img/mzyl.jpg',
                showContent: false
            }
        },
        computed: {},
        methods: {
            newPractice(){
                var self =this;
                axios.post('wx/algorithm/selectDetailedContent',{
                  id:this.$route.params.id
                }).then(function (res) {
                  self.newExercises=res.data.result[0].title;
                  self.algorithmtitle=res.data.result[0].content;
                  self.algorithmAnswer=res.data.result[0].answer;
                  self.Algorithmtitme=res.data.result[0].time;

                })
            },
            HistoryExercises(){
              this.$router.push("/historyAlgorithms");
            }
        },
        mounted() {
            this.newPractice();
        },

    }
</script>
<style>
.weui-cells__title{
    height: 40px;
    font-size: 20px  !important;
    color: #000  !important;
}

.ximg-demo {
    width: 100%;
    height: auto;
}

.ximg-error {
  background-color: yellow;
}

.slide {
  padding: 0 20px;
  overflow: hidden;
  max-height: 0;
  transition: max-height .5s cubic-bezier(0, 1, 0, 1) -.1s;
  background: #f0f0f0;
}

.animate {
  max-height: 9999px;
  transition-timing-function: cubic-bezier(0.5, 0, 1, 0);
  transition-delay: 0s;
}

pre { 
    white-space: pre-wrap; /*css-3*/ 
    white-space: -moz-pre-wrap; /*Mozilla,since1999*/ 
    white-space: -pre-wrap; /*Opera4-6*/ 
    white-space: -o-pre-wrap; /*Opera7*/ 
    word-wrap: break-word; /*InternetExplorer5.5+*/ 
} 

</style>