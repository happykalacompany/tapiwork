<style lang='scss'>
    @import '~@/abstracts/_variables.scss';
    div.cafe-page {
        h2 {
            text-align: center;
            color: $primary-color;
            font-family: 'Josefin Sans', sans-serif;
        }

        h3 {
            text-align: center;
            color: $secondary-color;
            font-family: 'Josefin Sans', sans-serif;
        }

        span.address {
            text-align: center;
            display: block;
            font-family: 'Lato', sans-serif;
            color: #A0A0A0;
            font-size: 20px;
            line-height: 30px;
            margin-top: 50px;
        }

        a.website {
            text-align: center;
            color: $dull-color;
            font-size: 30px;
            font-weight: bold;
            margin-top: 50px;
            display: block;
            font-family: 'Josefin Sans', sans-serif;
        }

        div.brew-methods-container {
            max-width: 700px;
            margin: auto;

            div.cell {
                text-align: center;
            }
        }
    }
    div.tag-contrainer{
        margin: auto;
        margin-top: 30px;
        max-width: 700px;
        text-align: center;

        span.tag{
            color: $dark-color;
            font-family: 'Times New Roman', Times, serif;
            margin-right: 20px;
            display: inline-block;
            line-height: 20px;
        }
    }
    
    div.togglelike-container{
        text-align: center;

        span.prompt-log-in{
            cursor: pointer;
            display: block;
            text-decoration: underline;
        }
    }
</style>

<template>
<div id="cafe" class="page">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="large-12 medium-12 small-12 cell">
                    <loader v-show="cafeLoadStatus === 1" :width="100" :height="100"></loader>
                    <div class="cafe-page" v-show="cafeLoadStatus === 2">
                        <h2>{{ cafe.name }}</h2>
                        <h3 v-if="cafe.location_name != ''">{{ cafe.location_name }}</h3>

                        <!--预留的喜欢组件放置的位置-->
                        <div class="togglelike-container">
                            <div class="grid-x">
                                <div class="large-12 medium-12 small-12 cell">
                                    <toggle-like v-if="user !='' && userLoadStatus === 2"></toggle-like>
                                    <span class="prompt-log-in" v-if="user === '' && userLoadStatus === 2" v-on:click="logIn()">登录后关注</span>
                                </div>
                            </div>
                        </div>
                        <div class="tag-contrainer">
                            <div class="grid-x">
                                <div class="large-12 medium-12 small-12 cell">
                                    <span class="tag" v-for="tag in cafe.tags">#{{tag.name}}</span>
                                </div>
                            </div>
                        </div>
                        <span class="address">
                            {{ cafe.address }}<br>
                            {{ cafe.city }},{{ cafe.state }}
                            {{ cafe.zip }}
                        </span>

                        <a class="website" v-bind:href="cafe.website" target="_blank">{{ cafe.website }}</a>

                        <div class="brew-methods-container">
                            <div class="grid-x grid-padding-x">
                                <div class="large-3 medium-4 small-12 cell" v-for="brewMethod in cafe.brew_methods">
                                    {{ brewMethod.method }}
                                </div>
                            </div>
                        </div>

                        <!--预留的放置具体咖啡店地图位置的组件-->
                        <individual-cafe-map></individual-cafe-map>
                    </div>
                </div>    
            <div>
        </div>        
    </div>
</div>
</div>
</template>

<script>
import IndividualCafeMap from '../components/cafes/IndividualCafeMap.vue';
import ToggleLike from '../components/cafes/ToggleLike.vue';
import Loader from '../components/global/Loader.vue';
import {EventBus} from '../event-bus.js';
export default {
    components:{
        IndividualCafeMap,
        ToggleLike,
        Loader
    },
    created(){
        //组件创建之后调用loadXafe方法加载具体的咖啡店信息
        this.$store.dispatch('loadCafe',{
            id:this.$route.params.id
        });
    },
    computed:{
        cafeLoadStatus(){
            return this.$store.getters.getCafeLoadStatus;
        },
        cafe(){
            return this.$store.getters.getCafe;
        },
        user(){
            return this.$store.getters.getUser;
        },
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