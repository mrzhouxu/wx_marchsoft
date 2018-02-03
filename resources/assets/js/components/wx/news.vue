<template>
	<div>
		<div style="width: 100%;height: 50px;background-color: #4d93db">
			<p style="width: 80px;height: 20px;margin: 18px 0 0 0;font-size: 13px;text-align: center;color: white;float: left">
				新闻动态</p>
			<p style="width: 80px;margin: 0 auto;height: 20px;padding: 15px 0;font-size: 15px;text-align: center;color: white">
				三月软件</p>
		</div>

		<alert v-model="show">{{ this.message }}</alert>

		<tab>
			<tab-item :selected="selectType === 0" @on-item-click="onItemClickTime">
				<group>
					<datetime v-model="value1" format="YYYY-MM" @on-change="change">
					</datetime>
				</group>
			</tab-item>
			<tab-item :selected="selectType === 1" @on-item-click="onItemClick">最新动态</tab-item>
		</tab>

		<panel :list="list" :type="type" :footer="footer" @on-click-footer="onclickfooter()"></panel>

	</div>
</template>
<script>
import {
	Grid,
	GridItem,
	GroupTitle,
	Datetime,
	Group,
	Tab,
	TabItem,
	Panel,
	LoadMore,
	InlineLoading,
	XButton,
	TransferDomDirective as TransferDom,
	Alert
} from 'vux'
import Router from 'vue-router';

Vue.use(Router)

export default {
	components: {
		Grid,
		GridItem,
		GroupTitle,
		Group,
		Datetime,
		Tab,
		TabItem,
		Panel,
		XButton,
		Alert

	},
	data() {
		return {
			test: '测试',
			test1: '生日',
			value1: '2015-12',
			type: '4',
			page: 1,
			list: [],
			selectType: 1,
			footer: {
				title: '加载更多',
			},
			show: false,
			message: '',
			url: '/News/getNew?page=',
			testType: '0'

		}
	},
	methods: {
		change(val) {
			console.log(val);
			this.testType = val;
		},
		onItemClick() {
			if (this.selectType == 0) {
				this.testType = '0'
				this.page = 1;
				this.selectType = 1;
				this.url = '/News/getNew?page=';
				this.initSelect();
			}
		},
		onItemClickTime() {
			if (this.selectType == 1) {

				this.selectType = 0;
				var obj_cancel = document.getElementsByClassName('dp-item dp-left vux-datetime-cancel')
				var obj_ok = document.getElementsByClassName('dp-item dp-right vux-datetime-confirm')
				var object = this;
				obj_cancel[0].addEventListener('click', function () {

					object.selectType = 1;
				})
				obj_ok[0].addEventListener('click', function () {
					object.page = 1;
					object.url = '/News/getNewTime?date=' + object.value1 + '&page='
					axios.get('/News/getNewTime?date=' + object.value1 + '&page=' + object.page).then(res => {
						object.timeInit(object, res);


					})


				})
			}
		},

		timeInit(object, res) {
			if (res.data.code == 0) {
				object.list = [{
					id: 0,
					title: '',
					desc: '',
					url: '',
					meta: {
						source: '',
						date: '',
						other: ''
					}
				}]

				var arr = res.data.result.data;
				for (let i in arr) {
					object.initList_I(object, i);
					object.list[i].id = arr[i].idmarch_news;
					object.list[i].title = arr[i].news_title;
					object.list[i].desc = arr[i].news_content.replace(/<\/?.+?>/g, "").replace(/ /g, "").substr(0, 100);
					object.list[i].url = "/newShow/" + arr[i].idmarch_news + '/' + this.testType;
					object.list[i].meta.source = "发布者:" + arr[i].news_publisher;
					object.list[i].meta.date = new Date(arr[i].news_date).format("yyyy-MM-dd");
					object.list[i].meta.other = "阅读量:" + arr[i].news_num

				}
			} else if (res.data.code == 2) {
				object.message = "暂无此时间段的新闻"
				object.show = true;
			} else {
				object.message = "哎呀！出错了"
				object.show = true;
			}
		},
		onclickfooter() {
			this.page++
			axios.get(this.url + this.page).then(res => {
				if (res.data.code == 0) {
					var arr = res.data.result.data;
					var length = this.list.length;
					length = parseInt(length);
					let list_copy = this.list
					this.list = [{
						id: 0,
						title: '',
						desc: '',
						url: '',
						meta: {
							source: '',
							date: '',
							other: ''
						}
					}]
					for (var i = 0; i < length; i++) {
						this.initList_I(this, i);
						this.list[i].id = list_copy[i].id;
						this.list[i].title = list_copy[i].title;
						this.list[i].desc = list_copy[i].desc;
						this.list[i].url = list_copy[i].url;
						this.list[i].meta.source = list_copy[i].meta.source;
						this.list[i].meta.date = list_copy[i].meta.date;
						this.list[i].meta.other = list_copy[i].meta.other;

					}
					for (let i in arr) {
						let j = length + parseInt(i);
						this.initList_I(this, j);
						this.list[j].id = arr[i].idmarch_news;
						this.list[j].title = arr[i].news_title;
						this.list[j].desc = arr[i].news_content.replace(/<\/?.+?>/g, "").replace(/ /g, "").substr(0, 100);
						this.list[j].url = "/newShow/" + arr[i].idmarch_news + '/' + this.testType;
						this.list[j].meta.source = "发布者:" + arr[i].news_publisher;
						this.list[j].meta.date = new Date(arr[i].news_date).format("yyyy-MM-dd");
						this.list[j].meta.other = "阅读量:" + arr[i].news_num
					}
				} else if (res.data.code == 2) {
					this.message = "已经到底了"
					this.show = true;
				} else {
					this.message = "哎呀！出错了"
					this.show = true;
				}

			})
		},

		initList_I(obj, i) {
			obj.list[i] = {
				id: 0,
				title: '',
				desc: '',
				url: '',
				meta: {
					source: '',
					date: '',
					other: ''
				}
			}
		},

		initSelect() {
			axios.get("/News/getNew?page=" + this.page).then(res => {
				this.list = [{
					id: 0,
					title: '',
					desc: '',
					url: '',
					meta: {
						source: '',
						date: '',
						other: ''
					}
				}]
				var arr = res.data.result.data;
				for (let i in arr) {
					this.initList_I(this, i);
					this.list[i].id = arr[i].idmarch_news;
					this.list[i].title = arr[i].news_title;
					this.list[i].desc = arr[i].news_content.replace(/<\/?.+?>/g, "").replace(/ /g, "").substr(0, 100);
					this.list[i].url = "/newShow/" + arr[i].idmarch_news + '/' + this.testType;
					this.list[i].meta.source = "发布者:" + arr[i].news_publisher;
					this.list[i].meta.date = new Date(arr[i].news_date).format("yyyy-MM-dd");
					this.list[i].meta.other = "阅读量:" + arr[i].news_num

				}
			})
		}


	},
	created: function () {

		if (this.$route.params.date == '0') {
			var date = new Date();
			var mytime = date.format('yyyy-MM');
			this.value1 = mytime;
			this.testType = '0'
		} else {
			this.value1 = this.$route.params.date;
			this.testType = this.value1;
		}
	},
	mounted: function () {
		if (this.$route.params.date == '0') {
			this.initSelect();
		} else {
			this.selectType = 0;
			this.value1 = this.$route.params.date;
			this.url = '/News/getNewTime?date=' + this.value1 + '&page='
			axios.get('/News/getNewTime?date=' + this.value1 + '&page=' + this.page).then(res => {
				this.timeInit(this, res);

			})
		}
	}
}
</script>


<style>
* {
  margin: 0;
  padding: 0;
}

a {
  text-decoration: none !important;
}

.weui-cells {
  margin-top: 0 !important;
}

.weui-cell__ft {
  text-align: center !important;
}

.weui-panel:before {
  border-top: 0px !important;
}
</style>