<template>
    <div>
        <div style="width: 100%;height: 50px;background-color: white">

            <p style="width: 100%;margin: 0 auto;height: 20px;padding: 15px 0;font-size: 15px;text-align: center;color: black;background-color: rgb(77, 147, 219);position: fixed">
                <a :href="this.url"><img style="float:left;width: 18px;margin: 0px 0px 0px 10px;"
                                              src="/img/back.png"/></a>
                <span style="margin-right: 8%;">三月软件</span>
            </p>

        </div>
        <h4 style="margin-top: 10px;padding: 0 15px;">{{ this.title }}</h4>
        <p style="width: 100%;
    margin-top: 2px;
    padding: 0 15px;
    color: rgb(231, 227, 227);
    font-size: 12px;
    margin-bottom: 0;"><span id="author" style="display: inline-block; width: 31%">上传者：{{ this.author }}</span><span
                style="display: inline-block;width: 40%">发布时间:{{ this.date }}</span><span
                style="display: inline-block;width: 28%">浏览:{{ this.number }}</span></p>
        <div id="content">

        </div>
    </div>
</template>
<script>

    import Router from 'vue-router';

    Vue.use(Router)

    export default {
        components: {
            name: 'params',
        },
        data() {
            return {
                url: '',
                title: "",
                date: '',
                author: '',
                number: ''
            }
        },
        methods: {},
        created: function () {
            if (this.$route.params.date != '0') {
                this.url = '/wx#/newList/' + this.$route.params.date
            } else {
                this.url = '/wx#/newList/0'
            }
        },
        mounted: function () {

            try {
                if (this.$route.params.pid != null) {
                    axios.get('News/new?pid=' + this.$route.params.pid).then(res => {
                        console.log(res)
                        if (res.data.code == 0) {
                            document.getElementById("content").innerHTML = res.data.result.news_content;
                            this.title = res.data.result.news_title;
                            this.date = res.data.result.news_date.substr(0, 10);
                            this.author = res.data.result.news_publisher;
                            this.number = res.data.result.news_num;
                        }
                    })
                }
            } catch (e) {

            }

        }
    }
</script>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    p {
        line-height: 1.4;
        word-wrap: break-word;
        padding: 0 5px;
        margin-bottom: 5px;
        font-size: 10px;
    }

    img {
        width: 80%;
        margin: 0 auto;
        display: block;
    }

    #content {
        margin: 15px 10px 0px 10px;
    }
</style>