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
        }
    ]
})

