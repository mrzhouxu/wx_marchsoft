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
        }



    ]
})

