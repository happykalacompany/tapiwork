<style lang="scss">
    @import '~@/abstracts/_variables.scss';
    div#home{
        a.add-cafe-button{
            float: right;
            display: block;
            margin-top: 10px;
            margin-bottom: 10px;
            background-color: $dark-color;
            color: white;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 10px;
            padding-right: 10px;
        }
        span.add-cafe-text{
            float: right;
            display: block;
            margin-top: 10px;
            margin-bottom: 10px;
            background-color: $dark-color;
            color: white;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 10px;
            padding-right: 10px;
            cursor: pointer;
        }
    }
</style>

<template>
    <div id="home">
        <div class="grid-container">
            <div class="grid-x">
                <div class="large-12 medium-12 small-12 columns">
                    <router-link v-if="user != '' && userLoadStatus === 2" v-show="userLoadStatus === 2" :to="{name:'newcafe'}" class="add-cafe-button">+新增咖啡</router-link>
                    <span class="add-cafe-text" v-if="user == '' && userLoadStatus === 2" v-on:click="logIn()">登录后新增咖啡店</span>
                </div>
            </div>
        </div>
        <cafe-filter></cafe-filter>
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <loader v-show="cafesLoadStatus == 1" :width="100" :height="100"></loader>
                <cafe-card v-for="cafe in cafes" :key="cafe.id" :cafe="cafe"></cafe-card>
            </div>
        </div>
    </div> 
</template>

<script>
import CafeFilter from '../components/cafes/CafeFilter.vue';
import CafeCard from '../components/cafes/CafeCard.vue';
import Loader from '../components/global/Loader.vue';
import {EventBus} from '../event-bus.js';
export default {
    components:{
        CafeFilter,
        CafeCard,
        Loader
    },
    created(){
        this.$store.dispatch('loadCafes');
    },
    /**
     * 定义组件的计算属性
     */
    computed:{
        //获取Cafes的加载状态
        cafesLoadStatus(){
            return this.$store.getters.getCafesLoadStatus;
        },
        //获取Cafes数据
        cafes(){
            return this.$store.getters.getCafes;
        },
        //获取当前用户的数据
        user(){
            return this.$store.getters.getUser;
        },
        //获取当前用户的加载状态
        userLoadStatus(){
            return this.$store.getters.getUserLoadStatus;
        }
    },
    methods:{
        logIn(){
            EventBus.$emit('promt-login');
        }
    }

    
}
</script>