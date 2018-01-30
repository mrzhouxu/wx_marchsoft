import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name: "首页",
            path: '/ss',
            component: resolve =>void(require(['../components/wx/final.vue'], resolve))

        },
    ]
})

