<style lang="scss">
    @import '~@/abstracts/_variables.scss';

    div.tags-input-container {
        position: relative;

        div.tags-input {
            display: table;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            width: 100%;
            height: auto;
            min-height: 100px;
            padding-top: 4px;
            border: 1px solid #cacaca;
            border-radius: 0;
            background-color: #FFFFFF;
            -webkit-box-shadow: inset 0 1px 2px rgba(17, 17, 17, 0.1);
            box-shadow: inset 0 1px 2px rgba(17, 17, 17, 0.1);
            font-family: inherit;
            font-size: 1rem;
            font-weight: normal;
            line-height: 1.5;
            color: #111111;

            div.selected-tag {
                border: 1px solid $dark-color;
                background: $highlight-color;
                font-size: 18px;
                color: $dark-color;
                padding: 3px;
                margin: 5px;
                float: left;
                border-radius: 3px;

                span.remove-tag {
                    margin: 0 0 0 5px;
                    padding: 0;
                    border: none;
                    background: none;
                    cursor: pointer;
                    vertical-align: middle;
                    color: $dark-color;
                }
            }

            input[type="text"].new-tag-input {
                border: 0px;
                margin: 0px;
                float: left;
                width: auto;
                min-width: 100px;
                -webkit-box-shadow: none;
                box-shadow: none;
                margin: 5px;

                &.duplicate-warning {
                    color: red;
                }

                &:focus {
                    box-shadow: none;
                }
            }
        }

        div.tag-autocomplete {
            position: absolute;
            background-color: white;
            width: 100%;
            padding: 5px 0;
            z-index: 99999;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);

            div.tag-search-result {
                padding: 5px 10px;
                cursor: pointer;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                color: $dark-color;
                font-size: 14px;
                background-color: white;

                &:hover {
                    background-color: $highlight-color;
                }
                &.selected-search-index {
                    background-color: $highlight-color;
                }
            }
        }
    }
</style>
<template>
    <div class="tags-input-container">
        <label>Tags</label>
        <div class="tags-input">
            <div class="selected-tag" v-for="(selectedTag,selectedKey) in tagsArray">
                {{ selectedTag }}
                <span class="remove-tag" v-on:click="removeTag(selectedKey)">x</span>
            </div>
            <input type="text" v-bind:id="unique" class="new-tag-input" v-model="currentTag" v-on:keyup="searchTags"
            v-on:keydown.up="changeIndex('up')" v-on:keydown.down="changeIndex('down')"
            v-on:keydown.enter="addNewTag" v-on:keydown.delete="handleDelete">
        </div>
        <!--展示筛选出来的标签数据-->
        <div class="tag-autocomplete" v-show="showAutoComplete">
            <div class="tag-search-result" v-for="(tag, key) in tagsSearchResultsArray"
                v-bind:class="{'selected-search-index':searchSelectedIndex === key}"
                v-on:click="selectTag(tag.name)">{{ tag.name }}</div>
        </div>
    </div>
</template>
<script>
import {TAPIWORK_CONFIG} from '../../../config.js';
import {EventBus} from '../../../event-bus.js';
import _ from 'lodash';
export default {
    props:['unique'],
    data(){
        return{
            currentTag:'',
            tagsArray:[],
            tagsSearchResultsArray:[],
            duplicateFlag:false,
            searchSelectedIndex:-1,
            pauseSearch:false
        } 
    },
    mounted(){
        //监听事件总线中的'clear-tags'时间，执行对应的操作  
        EventBus.$on('clear-tags',function(unique){
            this.currentTag = '';
            this.tagsArray = [];
            this.tagsSearchResultsArray = [];
            this.duplicateFlag = false;
            this.searchSelectedIndex = -1;
            this.pauseSearch = false;
        }.bind(this));
    },
    computed:{
        showAutoComplete(){
            return this.tagsSearchResultsArray.length !== 0;
        }
    },
    methods:{
        //搜索对应的标签数据,引入防抖动函数，演示300ms之后才提交数据查询
        searchTags:_.debounce(function(e){
            //当前输入标签长度大于2且是可搜索状态的时候
            if(this.currentTag.length > 0 && !this.pauseSearch){
                axios.get(TAPIWORK_CONFIG.API_URL + '/tags',{
                    params:{
                        search:this.currentTag
                    }
                }).then(function(response){
                    this.tagsSearchResultsArray = response.data;
                }.bind(this));
            }

            if(this.currentTag.length == 0 && !this.pauseSearch){
                this.tagsSearchResultsArray = [];
            }
        },300),
        //清理标签中的不需要的空格和字符串
        cleanTagsName(tagName){
            var cleanTag = tagName.trim();
            return cleanTag;
        },
        //检查标签是否已经在数组中存在
        checkDuplicate(tagName){
            var tagName = this.cleanTagsName(tagName);
            return this.tagsArray.indexOf(tagName) > -1;
        },
        //重置标签输入框
        resetInput(){
            this.currentTag = '';
            this.tagsSearchResultsArray = [];
            this.duplicateFlag = false;
            this.pauseSearch = false;
            this.searchSelectedIndex = -1;
        },
        //从下拉提示列表中选择提示的标签
        selectTag(tag){
            if(!this.checkDuplicate(tag)){//标签不在数组中
                var tag = this.cleanTagsName(tag);
                this.tagsArray.push(tag);
                //广播这个标签变动事件，对应的在父组件中会有监听处理
                EventBus.$emit('tags-edited',{unique:this.unique,tags:this.tagsArray});
                //重置输入框
                this.resetInput();
            }else{//标签在数组中
                this.duplicateFlag = true;
            }
        },
        addNewTag(){
            if(!this.checkDuplicate(this.currentTag)){//标签不在数组中
                var tag = this.cleanTagsName(this.currentTag);
                this.tagsArray.push(tag);
                //广播这个标签变动事件，对应的在父组件中会有监听处理
                EventBus.$emit('tags-edited',{unique:this.unique,tags:this.tagsArray});
                //重置输入框
                this.resetInput();
            }else{//标签在数组中
                this.duplicateFlag = true;
            }
        },
        //移除标签
        removeTag(tagIndex){
            this.tagsArray.splice(tagIndex,1);
            var id = this.unique;
            EventBus.$emit('tags-edited',{unique:this.unique,tags:this.tagsArray});
        },
        changeIndex(direction){
            this.pauseSearch = true;
            if(direction == 'up' && this.searchSelectedIndex - 1 > -1 ){
                this.searchSelectedIndex = this.searchSelectedIndex - 1;
                this.currentTag = this.tagsSearchResultsArray[this.searchSelectedIndex].name;
            }

            if(direction == 'down' && this.searchSelectedIndex < this.tagsSearchResultsArray.length){
                this.searchSelectedIndex = this.searchSelectedIndex + 1;
                this.currentTag = this.tagsSearchResultsArray[this.searchSelectedIndex].name;
            }
        },
        handleDelete(){
            this.duplicateFlag = false;
            this.searchSelectedIndex = -1;
            this.pauseSearch = false;
            if(this.currentTag === 0){
                this.tagsArray.splice(this.tagsArray.length - 1,1);
                //在事件总线中发射这个tags值变化的数据
                EventBus.$emit('tags-edited',{unique:this.unique,tags:this.tagsArray});
            }
        }   
    }
}
</script>
