/**
 |-------------------------------------
 |routes.js 改文件包含有所有的应用路由信息 
 |------------------------------------- 
 */

 /**
  * 引入Vue 和 VueRouter 来扩展路由 
  */

  import Vue from 'vue';
  import VueRouter from 'vue-router';
  import store from './store.js';  
/**
 * 使用VueRouter来扩展Vue的路由
 */

 Vue.use(VueRouter);

 /**
  * 路由守卫的处理函数
  */
 function requiredAuth(to,from,next){
     //路由守卫处理函数
    function process(){
        if(store.getters.getUserLoadStatus() === 2){
            if(store.getters.getUser != ''){
                next();
            }
        }else{
            next('/home');
        }
    }

    if(store.getters.getUserLoadStatus() !=2){//说明数据还没有加载完毕
        store.dispatch('loadUser');

        //监听加载状态的变化，watch第一个参数必须是函数
        store.watch(store.getters.getUserLoadStatus,function(){
            if(store.getters.getUserLoadStatus() === 2){
                process();
            }
        })
    }else{//记载完毕的情况下直接处理
        process();
    }

 }

/**
 * 定义路由
 */
 export default new VueRouter({
    routes:[
        {
            path:'/',
            redirect:{name:'home'},
            name:'layout',
            component:Vue.component('Home',require('./pages/Layout.vue')),
            children:[
                    {
                        path:'home',
                        name:'home',
                        component:Vue.component('Home',require('./pages/Home.vue'))
                     },
                     {
                       path:'cafes',
                       name:'cafes',
                       component:Vue.component('Cafes',require('./pages/Cafes.vue')) 
                     },
                     {
                         path:'cafes/new',
                         name:'newcafe',
                         component:Vue.component('NewCafe',require('./pages/NewCafe.vue')),
                         beforeEnter:requiredAuth
                     },
                     {
                         path:'cafes/:id',
                         name:'cafe',
                         component:Vue.component('Cafe',require('./pages/Cafe.vue'))
                     },
                     {
                         path:'profile',
                         name:'profile',
                         component:Vue.component('Profile',require('./pages/Profile.vue'))
                     }
            ]
        }
    ]
 });
