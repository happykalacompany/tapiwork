<style lang="scss">
    @import '~@/abstracts/_variables.scss';

  div.filter-brew-method{
    display: inline-block;
    height: 35px;
    text-align: center;
    border: 1px solid #ededed;
    border-radius: 5px;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 5px;
    padding-bottom: 5px;
    margin-right: 10px;
    margin-top: 10px;
    cursor: pointer;
    color: $dark-color;
    font-family: 'Josefin Sans', sans-serif;

    &.active{
      border-bottom: 4px solid $primary-color;
    }
  }
  span.show-filters{
    display: block;
    margin: auto;
    color: $dark-color;
    font-family: 'Josefin Sans', sans-serif;
    cursor: pointer;
    font-size: 14px;
}
</style>
<template>
    <div id="cafe-filter">
        <div class="grid-container" v-show="show">
            <div class="grid-x grid-padding-x">
                <div class="large-6 medium-6 small-12 cell">
                    <label>搜索框</label>
                    <input type="text" v-model="textSearch" placeholder="请搜索">
                </div>
                <div class="large-6 medium-6 small-12 cell">
                    <tags-input v-bind:unique="'cafe-search'"></tags-input>
                </div>
                <div class="is-roaster-container">
                    <input type="checkbox" v-model="isRoaster"/><label>是否是烘焙店？</label>
                </div>
                <div class="brew-methods-container">
                    <div class="filter-brew-method" v-for="method in cafeBrewMethods" 
                                v-bind:class="{'active':brewMethods.indexOf(method.method) > -1}"
                                v-on:click="toggleBrewMethodFilter(method.method)">
                        {{ method.method }}
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <span class="show-filters" v-on:click="show=!show">{{ show?'隐藏筛选条件↑':'显示筛选条件↓' }}</span>
            </div>
        </div>
    </div>
</template>
<script>
//引入标签输入组件
import TagsInput from '../global/forms/TagsInput.vue';
//引入事件总线
import {EventBus} from '../../event-bus.js';
export default {
    data(){
        return{
            textSearch:'',
            tags:[],
            isRoaster:false,
            brewMethods:[],
            show:false
        }
    },
    components:{
        TagsInput
    },
    mounted(){
        EventBus.$on('tags-edited',function(tagsEdited){
            if(tagsEdited.unique == 'cafe-search'){
                this.tags = tagsEdited.tags;
            }
        }.bind(this));
    },
    computed:{
        cafeBrewMethods(){
            return this.$store.getters.getBrewMethods;
        }
    },
    methods:{
        //方法用于处理冲调方法的处理有的去掉，没有的加入到数组中
        toggleBrewMethodFilter(method){
            if(this.brewMethods.indexOf(method) > -1){
                this.brewMethods.splice(this.brewMethods.indexOf(method),1);
            }else{
                this.brewMethods.push(method);
            }
        },
        updateFilterCondition(){
            EventBus.$emit('filters-updated',{
                text:this.textSearch,
                tags:this.tags,
                roaster:this.isRoaster,
                brew_method:this.brewMethods
            });
        }
    },
    watch:{
        //监听变量的变化，每一个筛选条件变化之后都调用函数在时间总线中发送筛选值的变化
        textSearch(){
            this.updateFilterCondition();
        },
        tags(){
            this.updateFilterCondition();
        },
        isRoaster(){
            this.updateFilterCondition();
        },
        brewMethods(){
            this.updateFilterCondition();
        }
    }
}
</script>   
