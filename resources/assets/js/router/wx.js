import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        // {
        //     name: "首页",
        //     path: '/',
        //     component: resolve =>void(require(['../components/wx/Wxtest.vue'], resolve))
        // },
        {

            name: "首页",
            path: '/tt',
            component: resolve =>void(require(['../components/wx/TT.vue'], resolve))

        },
        {

            name: "首页",
            path: '/ss',
            component: resolve =>void(require(['../components/wx/final.vue'], resolve))

        },
        {

            name: "首页",
            path: '/ss',
            component: resolve =>void(require(['../components/wx/layout/menu.vue'], resolve))

        },
        {

            name: "首页",
            path: '/select',
            component: resolve =>void(require(['../components/wx/select/select.vue'], resolve))

        }
    ]
})

