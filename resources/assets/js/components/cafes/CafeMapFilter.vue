<style lang="scss">
     @import '~@/abstracts/_variables.scss';
     div#cafe-map-filter{
         position: absolute;
         background-color: white;
         border-radius: 10px;
         box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16), 0 0 0 1px rgba(0, 0, 0, 0.08);
         z-index: 99999;
         padding: 5px;
         right:50px;
         top: 50px;
         width: 25%;
     }

     div.filter-brew-method{
        display: inline-block;
        height: 30px;
        border: 1px solid #ededed;
        border-radius: 5px;
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        margin-right: 10px;
        margin-top: 10px;
        text-align: center;
        font-family: 'Courier New', Courier, monospace;
        font-size: 12px;
        cursor: pointer;
        color: #7F5F2A;
        
        &active{
            border-bottom: 4px solid $primary-color;
        }
     }
</style>
<template>
    <div id="cafe-map-filter">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="large-12 medium-12 small-12 cell">   
                    <label>搜索</label>
                    <input type="text" v-model="textSearch" />
                    <div class="is-roaster-cafe">
                        <input type="checkbox" v-model="isRoaster" /><label>烘焙店</label>
                    </div>
                    <div class="brew-methods-container">
                        <div class="filter-brew-method" v-for="method in cafeBrewMethods" 
                            v-bind:class="{'active':brewMethods.indexOf(method.method) > -1}"
                            v-on:click="toggleCafeBrewMethods(method.method)">
                            {{ method.method }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {EventBus} from '../../event-bus.js';
export default {
    data(){
        return{
            textSearch:'',
            isRoaster:false,
            brewMethods:[]
        }
    },
    computed:{
        cafeBrewMethods(){
            return this.$store.getters.getBrewMethods;
        }
    },
    methods:{
        toggleCafeBrewMethods(method){
            if(this.brewMethods.indexOf(method) > -1){
                this.brewMethods.splice(this.brewMethods.indexOf(method),1);
            }else{
                this.brewMethods.push(method);
            }
        },
        updateDisplayCondition(){
            //这只tags为空避免监听报错了
            EventBus.$emit('filters-updated',{
                text:this.textSearch,
                tags:[],
                roaster:this.isRoaster,
                brew_method:this.brewMethods
            });
        }
    },
    watch:{
        textSearch(){
            this.updateDisplayCondition();
        },
        isRoaster(){
            this.updateDisplayCondition();
        },
        brewMethods(){
            this.updateDisplayCondition();
        }
    }
}
</script>
