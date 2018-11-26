<style lang="scss">
    @import '~@/abstracts/_variables.scss';

    div.cafe-card {
        border-radius: 5px;
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16), 0 0 0 1px rgba(0, 0, 0, 0.08);
        padding: 15px 5px 5px 5px;
        margin-top: 20px;
        cursor: pointer;
        -webkit-transform: scaleX(1) scaleY(1);
        transform: scaleX(1) scaleY(1);
        transition: .2s;
        span.title {
            display: block;
            text-align: center;
            color: black;
            font-size: 18px;
            font-weight: bold;
            font-family: 'Lato', sans-serif;
        }
        span.address {
            display: block;
            text-align: center;
            margin-top: 5px;
            color: $grey;
            font-family: 'Lato', sans-serif;
            span.street {
                font-size: 14px;
                display: block;
            }
            span.city {
                font-size: 14px;
            }
            span.state {
                font-size: 14px;
            }
            span.zip {
                font-size: 14px;
                display: block;
            }
        }
        span.liked-meta {
            color: $grey;
            font-size: 10px;
            margin-left: 5px;
            margin-right: 3px;
            img {
                width: 10px;
            }
        }
        &:hover {
            -webkit-transform: scaleX(1.041) scaleY(1.041);
            transform: scaleX(1.041) scaleY(1.041);
            transition: .2s;
        }
    }
</style>
<template>
    <div class="large-3 medium-4 small-6 cell cafe-card-container" v-show="show">
        <router-link :to="{name:'cafe',params:{id:cafe.id}}">
            <div class="cafe-card">
                <span class="title">{{ cafe.name }}</span>
                <span class="address">
                    <span class="street">{{ cafe.address }}</span>
                    <span class="city">{{ cafe.city }}</span> <span class="state">{{ cafe.state }}</span>
                    <span class="zip">{{ cafe.zip }}</span>
                </span>
            </div>
        </router-link>
    </div>
</template>
<script>
import { CafeBrewMethodsFilter } from '../../mixins/filters/CafeBrewMethodsFilter.js';
import { CafesIsRoasterFilter } from '../../mixins/filters/CafeIsRoasterFilter.js';
import { CafeTagsFilter } from '../../mixins/filters/CafeTagsFilter.js';
import { CafeTextFilter } from '../../mixins/filters/CafeTextFilter.js';
import { EventBus } from '../../event-bus.js';
export default {
    data(){
        return {
            show:true
        }
    },
    props:['cafe'],
    mounted(){
        //监听事件总线中的filters-updated事件
        EventBus.$on('filters-updated',function(filters){
            this.processFilter(filters);
        }.bind(this));
    },
    methods:{
        processFilter(filters){
            if(filters.text == '' 
                && filters.tags.length == 0
                && filters.roaster == false
                && filters.brew_method.length == 0){//没有设置任何的筛选条件
                    this.show = true;
            }else{
                //定义显示控制常量
                var textPass = false;
                var tagsPass = false;
                var roasterPass = false;
                var brewMethodPass = false;
                //筛选输入字符串的显示
                if(filters.text != '' && this.processCafeTextFliter(this.cafe,filters.text)){
                    textPass = true;
                }else if(filters.text == ''){
                    textPass = true;
                }

                //是否是烘焙店的显示
                if(filters.roaster && this.processCafeIsRosterFilter(this.cafe)){
                    roasterPass = true;
                }else if(!filters.roaster){
                    roasterPass = true;
                }

                //标签筛选
                if(filters.tags.length > 0 && this.processCafeTagsFilter(this.cafe,filters.tags)){
                    
                    tagsPass = true;
                }else if(filters.tags.length == 0){
                    tagsPass = true;
                }

                //冲调方法的筛选
                if(filters.brew_method.length > 0 && this.processCafeBrewMethodsFilter(this.cafe,filters.brew_method)){
                    brewMethodPass = true;
                }else if(filters.brew_method.length == 0){
                    brewMethodPass = true;
                }

                //综合判断获取最终是否显示卡片控制
                if(textPass && tagsPass && roasterPass && brewMethodPass){
                    this.show = true;
                }else{
                    this.show = false;
                }
            }
        }
    },
    mixins:[
        CafeBrewMethodsFilter,
        CafesIsRoasterFilter,
        CafeTagsFilter,
        CafeTextFilter
    ]
}
</script>
