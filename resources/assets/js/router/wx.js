import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name: "首页",
            path: '/',
            component: resolve =>void(require(['../components/wx/Wxtest.vue'], resolve))
        },
        {

            name: "首页",
            path: '/tt',
            component: resolve =>void(require(['../components/wx/TT.vue'], resolve))

        },
        {
            name: "课堂",
            path: '/lecture/index',
            component: resolve =>void(require(['../components/wx/lecture/index.vue'], resolve))
        },
        {
            name: "详细视频",
            path: '/lecture/detaile/:theme/:user/:content/:sort/:data/:file',
            component: resolve =>void(require(['../components/wx/lecture/detaile.vue'], resolve))
        }
    ]
})

