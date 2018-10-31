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

/**
 * 使用VueRouter来扩展Vue的路由
 */

 Vue.use(VueRouter);
/**
 * 定义路由
 */
 export default new VueRouter({
     routes:[
         {
            path:'/',
            name:'home',
            component:Vue.component('Home',require('./pages/Home.vue'))
         },
         {
           path:'/cafes',
           name:'cafes',
           component:Vue.component('Cafes',require('./pages/Cafes.vue')) 
         },
         {
             path:'/cafes/new',
             name:'newcafe',
             component:Vue.component('NewCafe',require('./pages/NewCafe.vue'))
         },
         {
             path:'/cafes/:id',
             name:'cafe',
             component:Vue.component('Cafe',require('./pages/Cafe.vue'))
         }
     ]
 });
