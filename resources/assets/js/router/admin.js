import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name: "首页",
            path: '/',
            component: resolve =>void(require(['../components/admin/layout/index.vue'], resolve))
        },
        {
            name: "自动回复",
            path: '/wx/reply',
            component: resolve =>void(require(['../components/admin/wx/reply.vue'], resolve))
        },
        {
            name: '基础配置',
            path: '/wx/config',
            component: resolve =>void(require(['../components/admin/wx/config.vue'], resolve))
        },
        {
            name: '模板配置',
            path: '/wx/template',
            component: resolve =>void(require(['../components/admin/wx/temp.vue'], resolve))
        },
        {
            name: '菜单配置',
            path: '/wx/menu',
            component: resolve =>void(require(['../components/admin/wx/menu.vue'], resolve))
        },
        {

            name: '新闻列表',
                path: '/wx/new',
            component: resolve =>void(require(['../components/admin/wx/new.vue'], resolve))
        },
        {
            name: '添加新闻',
                path: '/wx/newsEdit',
            component: resolve =>void(require(['../components/admin/wx/newsEdit.vue'], resolve))
        },
        {
            name: '联系我们管理',
                path: '/wx/contact',
            component: resolve =>void(require(['../components/admin/wx/contact.vue'], resolve))
        },
        {
            name: '新生路线',
                path: '/wx/road',
            component: resolve =>void(require(['../components/admin/wx/roadEdit.vue'], resolve))
        },
        {

            name: '讲课列表',
            path: '/lecture/backindex',
            component: resolve =>void(require(['../components/admin/lecture/index.vue'], resolve))
        },
        {
            name: '发布讲课',
            path: '/lecture/newlec',
            component: resolve =>void(require(['../components/admin/lecture/newlec.vue'], resolve))
        },

         {
            name: '培训报名',
            path: '/15',
            component: resolve =>void(require(['../components/admin/layout/Train.vue'], resolve))
        },
         {
            name: '三月报名',
            path: '/14',
            component: resolve =>void(require(['../components/admin/layout/March.vue'], resolve))
        },
         {
            name: '修改信息',
            path: '/mod',
            component: resolve =>void(require(['../components/admin/layout/modify.vue'], resolve))
        },
		{
            name: "发布算法",
            path: '/addalgorithmslist',
            component: resolve =>void(require(['../components/admin/weeklyExercise/PublishingAlgorithm.vue'], resolve))
        },
        {
            name: "算法列表",
            path: '/algorithmslist',
            component: resolve =>void(require(['../components/admin/weeklyExercise/AlgorithmList.vue'], resolve))
        },
        {
            name:"毕业学子",
            path: '/userinfo/infoindex',
            component: resolve =>void(require(['../components/admin/userInfo/index.vue'], resolve))

        }
    ]
})

