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
        {
            name: "每周一练",
            path: '/algorithms',
            component: resolve =>void(require(['../components/wx/weeklyExercise/algorithm.vue'], resolve))
        },
        {
            name: "历史习题",
            path: '/historyAlgorithms',
            component: resolve =>void(require(['../components/wx/weeklyExercise/historyalgorithm.vue'], resolve))
        },
        {
            name: "详细习题内容",
            path: '/detailedAlgorithms/:id',
            component: resolve =>void(require(['../components/wx/weeklyExercise/detailedContent.vue'], resolve))
        },
    ]
})

