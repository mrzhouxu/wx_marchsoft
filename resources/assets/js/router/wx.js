import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
         {
            name: "首页",
            path: '/',
            component: resolve => void (require(['../components/wx/Wxtest.vue'], resolve))
        },
        // {
        //     name: "首页",
        //     path: '/tt',
        //     compoqnent: resolve =>void(require(['../components/wx/TT.vue'], resolve))
        // },
        {
            name: "首页",
            path: '/ss',
            component: resolve =>void(require(['../components/wx/Complete.vue'], resolve))

        },
         {
            name: "首页",

            path: '/newList/:date',
            component: resolve => void (require(['../components/wx/news.vue'], resolve))

        },
        {

            name: "Show",
            path: '/newShow/:pid/:date',

            component: resolve => void (require(['../components/wx/new.vue'], resolve))

        }, {
            name: "student",
            path: '/student',
            component: resolve => void (require(['../components/wx/student.vue'], resolve))
        },
         {
            name: "getStudent",
            path: '/getStudent/:pid',
            component: resolve => void (require(['../components/wx/studentDetails.vue'], resolve))
        },
        {
            name: "addOUr",
            path: '/addour',
            component: resolve => void (require(['../components/wx/addOur.vue'], resolve))
        },{
            name:"getRoad",
                path:'/Road',
            component:resolve => void (require(['../components/wx/road.vue'], resolve))
        },




    {
        name: "首页",
            path: '/ss',
            component: resolve =>void(require(['../components/wx/layout/Cultivate.vue'], resolve))

        },
        // {
        //     name: "首页",
        //     path: '/tt',
        //     component: resolve =>void(require(['../components/wx/TT.vue'], resolve))

        // },
        {
            name: "课堂",
            path: '/lecture/index',
            component: resolve =>void(require(['../components/wx/lecture/index.vue'], resolve))
        },
        {
            name: "详细视频",
            path: '/lecture/detaile/:theme/:user/:content/:sort/:data/:file',
            component: resolve =>void(require(['../components/wx/lecture/detaile.vue'], resolve))
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

