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

            name: "新闻",
            path: '/newShow/:pid/:date',

            component: resolve => void (require(['../components/wx/new.vue'], resolve))

        }, {
            name: "学子",
            path: '/student',
            component: resolve => void (require(['../components/wx/student.vue'], resolve))
        },
         {
            name: "get学子",
            path: '/getStudent/:pid',            
            component: resolve => void (require(['../components/wx/studentDetails.vue'], resolve))
        }


    ]
})

