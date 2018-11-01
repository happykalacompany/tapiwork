require('es6-promise').polyfill();

//导入vue和vuex
import Vue from 'vue';
import Vuex from 'vuex';

//初始化Vuex
Vue.use(Vuex);
import { cafes } from './modules/cafes.js';
//将数据存储对象开放出去
export default new Vuex.Store({
    modules:{
        cafes
    }
});