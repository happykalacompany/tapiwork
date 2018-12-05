<style lang="scss">

</style>

<template>
    <div class='page'>
        <form>
            <div class="grid-container">
                <div class="grid-x grid-padding-x">
                    <div class="large-12 medium-12 small-12 cell">
                        <label>名称
                            <input type="text" placeholder="咖啡店名" v-model="name">
                        </label>
                        <span class="validation" v-show="!validations.name.is_valid">{{ validations.name.text }}</span>
                    </div>
                    <div class="large-12 medium-12 small-12 cell">
                        <label>网址
                            <input type="text" placeholder="网址" v-model="website">
                        </label>
                        <span class="validation" v-show="!validations.website.is_valid">{{ validations.website.text }}</span>
                    </div>
                    <div class="large-12 medium-12 small-12 cell">
                        <label>简介
                            <input type="text" placeholder="简介" v-model="description">
                        </label>
                    </div>
                    <div class="large-12 medium-12 small-12 cell">
                        <label>图片
                            <input type="file" id="cafe-photo" ref="photo" v-on:change="handleFileChange()">
                        </label>
                    </div>
                </div>

                <div class="grid-x grid-padding-x" v-for="(location, key) in locations">
                    <div class="large-12 medium-12 small-12 cell">
                        <h5>位置</h5>
                    </div>
                    <div class="large-6 medium-6 small-12 cell">
                        <label>位置名称
                            <input type="text" placeholder="位置名称" v-model="locations[key].name">
                        </label>
                    </div>
                    <div class="large-6 medium-6 small-12 cell">
                        <label>详细地址
                            <input type="text" placeholder="详细地址" v-model="locations[key].address">
                        </label>
                        <span class="validation" v-show="!validations.locations[key].address.is_valid">{{ validations.locations[key].address.text }}</span>
                    </div>
                    <div class="large-6 medium-6 small-12 cell">
                        <label>城市
                            <input type="text" placeholder="城市" v-model="locations[key].city">
                        </label>
                        <span class="validation" v-show="!validations.locations[key].city.is_valid">{{ validations.locations[key].city.text }}</span>
                    </div>
                    <div class="large-6 medium-6 small-12 cell">
                        <label>省份
                            <input type="text" placeholder="省份" v-model="locations[key].state">
                        </label>
                        <span class="validation" v-show="!validations.locations[key].state.is_valid">{{ validations.locations[key].state.text }}</span>
                    </div>
                    <div class="large-6 medium-6 small-12 cell">
                        <label>邮政编码
                            <input type="text" placeholder="邮政编码" v-model="locations[key].zip">
                        </label>
                        <span class="validation" v-show="!validations.locations[key].zip.is_valid">{{ validations.locations[key].zip.text }}</span>
                    </div>
                    <div class="large-12 medium-12 small-12 cell">
                        <label>冲调方法</label>
                        <span class="brewMethod" v-for="brewMethod in brewMethods">
                            <input type="checkbox" v-bind:id="'brew-method-'+brewMethod.id+'-'+key" v-bind:value="brewMethod.id" v-model="locations[key].methodsAvailable">
                            <label v-bind:for="'brew-method-'+brewMethod.id+'-'+key">{{ brewMethod.method }}</label>
                        </span>
                    </div>
                    <div class="large-12 medium-12 small-12 cell">
                        <tags-input v-bind:unique="key"></tags-input>
                    </div>
                    <div class="large-12 medium-12 small-12 cell">
                        <a class="button" v-on:click="removeLocation(key)">移除位置</a>
                    </div>
                </div>

                <div class="grid-x grid-padding-x">
                    <div class="large-2 medium-2 small-2 cell">
                        <a class="button" v-on:click="addLocation()">新增位置</a>
                    </div>
                    <div class="large-1 medium-1 small-1 cell">
                        <a class="button" v-on:click="submitNewCafe()">提交</a>
                    </div>

                </div>    
            </div>
        </form>
    </div>    
</template>

<script>
import TagsInput from '../components/global/forms/TagsInput.vue';
import {EventBus} from '../event-bus.js';
export default {
    components:{
        TagsInput
    },
    data(){
        return {
            name:'',
            locations:[],
            website:'',
            description:'',
            roaster:false,
            picture:'',
            validations:{
                name:{
                    is_valid:true,
                    text:''
                },
                locations:[],
                oneLocation:{
                    is_valid:true,
                    text:''
                },
                website:{
                    is_valid:false,
                    text:''
                }
            }
        }
    },
    methods:{
        //数据提交方法
        submitNewCafe:function(){
            if(this.validateNewCafe()){
                this.$store.dispatch('addCafe',{
                    name:this.name,
                    locations:this.locations,
                    website:this.website,
                    description:this.description,
                    roaster:this.roaster,
                    picture:this.picture
                });
            }
        },
        //数据验证方法
        validateNewCafe:function(){
            let validNewCafeForm = true;

            //检测名字
            if(this.name.trim() === ''){
                validNewCafeForm = false;
                this.validations.name.is_valid = false;
                this.validations.name.text = '请输入咖啡厅的名字';
            }else{
                this.validations.name.is_valid = true;
                this.validations.name.text = '';
            }

            //验证网址
            if(this.website.trim() === ''){
                validNewCafeForm = false;
                this.validations.website.is_valid = false;
                this.validations.website.text = '请输入网址';
            }else{
                this.validations.website.is_valid = true;
                this.validations.website.text = '';
            }

            for(var index in this.locations){
                //检测详细地址
                // if(this.locations.hasOwnproperty(index)){
                    if(this.locations[index].address.trim() === ''){
                        validNewCafeForm = false;
                        this.validations.locations[index].address.is_valid = false;
                        this.validations.locations[index].address.text = '请输入咖啡厅的地址';
                    }else{
                        this.validations.locations[index].address.is_valid = true;
                        this.validations.locations[index].address.text = '';
                    }
                // }
                //检测城市
                if(this.locations[index].city.trim() === ''){
                    this.validations.locations[index].city.is_valid = false;
                    this.validations.locations[index].city.text = '请输入咖啡厅所在的城市';
                }else{
                    this.validations.locations[index].city.is_valid = true;
                    this.validations.locations[index].city.text = '';
                }

                //检测省份
                if(this.locations[index].state.trim() === ''){
                    this.validations.locations[index].state.is_valid = false;
                    this.validations.locations[index].state.text = '请输入咖啡厅所在的省份';
                }else{
                    this.validations.locations[index].state.is_valid = true;
                    this.validations.locations[index].state.text = '';
                }

                //检测邮政编码
                if(this.locations[index].zip.trim() === ''){
                    this.validations.locations[index].zip.is_valid = false;
                    this.validations.locations[index].zip.text = '请输入咖啡厅所在地的邮政编码';
                }else{
                    this.validations.locations[index].zip.is_valid = true;
                    this.validations.locations[index].zip.text = '';
                }
            }
            return validNewCafeForm;
        },
        //添加咖啡店的位置,在表单中添加位置和位置对应的验证
        addLocation(){
             this.locations.push({
                 name: '', 
                 address: '', 
                 city: '', 
                 state: '', 
                 zip: '', 
                 methodsAvailable: [],
                 tags:''
            });
            this.validations.locations.push({
                address:{
                    is_valid:true,
                    text:''
                },
                city:{
                    is_valid:true,
                    text:''
                },
                state:{
                    is_valid:true,
                    text:''
                },
                zip:{
                    is_valid:true,
                    text:''
                }
            })
        },
        //移除一个分店表单
        removeLocation(key){
            this.locations.splice(key,1);
            this.validations.locations.splice(key,1);
        },
        //重置清理form表单
        clearForm(){
            this.name = '';
            this.locations = [];
            this.website = '';
            this.roaster = false;
            this.description = '';
            this.picture = '';
            this.$refs.photo.value = '';
            this.validations = {
                name:{
                    is_valid:true,
                    text:''
                },
                locations:[],
                oneLocation:{
                    is_valid:true,
                    text:''
                },
                website:{
                    is_valid:true,
                    text:''
                }
            };
            //清空表单的时候发送clear-tags事件，这个事件会被标签组件监听下来并作出初始化tags输入的动作
            EventBus.$emit('clear-tags');
            this.addLocation();
        },
        handleFileChange(){
            this.picture = this.$refs.photo.files[0];
        }
    },
    created(){
        //在组件创建之后调用addLocation方法设置一个初始位置
        this.addLocation();
    },
    mounted(){
        EventBus.$on('tags-edited',function(tagsAdded){
            this.locations[tagsAdded.unique].tags = tagsAdded.tags;
        }.bind(this));
    },
    computed:{
        //计算属性获取可以使用的冲调方法
        brewMethods(){
            return this.$store.getters.getBrewMethods;
        },
        addCafeStatus(){
            return this.$store.getters.getCafeAddStatus;
        }
    },
    watch:{
        'addCafeStatus':function(){
            if(this.addCafeStatus === 2){
                //添加成功
                this.clearForm();
                console.log('添加成功');
                // $('#cafe-added-successfully').show().delay(5000).fadeOut();   
            }else if(this.addCafeStatus === 3){
                //添加失败
                // $('#cafe-added-unsuccessfully').show().delay(5000).fadeOut();
                console.log('添加失败');
            }
        }
    }
}
</script>    