<style lang="scss">
    @import '~@/abstracts/_variables.scss';
</style>
<template>
    <div class="profile-page">
        <div id="profile-updated-successfully" class="notification success">
            个人信息更新成功
        </div>
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <loader v-show="userLoadStatus === 1" :width="100" :height="100"></loader>
            </div>
        </div>
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="large-12 medium-10 small-12 cell center">
                    <span>
                        最喜欢的咖啡
                        <textarea v-model="favorite_coffee"></textarea>
                    </span>
                </div>
            </div>
            <div class="grid-x grid-padding-x">
                <div class="large-12 medium-10 small-12 cell center">
                    <span>
                        味道记录
                        <textarea v-model="flavor_note"></textarea>
                    </span>
                </div>
            </div>
            <div class="grid-x grid-padding-x">
                <div class="large-12 medium-10 small-12 cell center">
                    <span>
                        个人信息是否公开
                        <select id="public-profile" v-model="profile_visibility">
                            <option value="0">不公开</option>
                            <option value="1">公开</option>
                        </select>
                    </span>
                </div>
            </div>
            <div class="grid-x grid-padding-x">
                <div class="large-12 medium-10 small-12 cell center">
                    <span>
                        城市
                        <input type="text" v-model="city" />
                    </span>
                </div>
            </div>
            <div class="grid-x grid-padding-x">
                <div class="large-12 medium-10 small-12 cell center">
                    <span>
                        省份
                        <input type="text" v-model="state" />
                    </span>
                </div>
            </div>
            <div class="grid-x grid-padding-x">
                <div class="large-12 medium-10 small-12 cell center">
                    <a class="button update-profile" v-on:click="updateProfile()">更新个人信息</a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Loader from '../../components/global/Loader.vue';
export default {
    data(){
        return {
            favorite_coffee:'',
            flavor_note:'',
            profile_visibility:0,
            city:'',
            state:''
        }
    },
    components:{
        Loader
    },
    computed:{
        userLoadStatus(){
            return this.$store.getters.getUserLoadStatus();
        },
        user(){
            return this.$store.getters.getUser;
        },
        putUserUpdateStatus(){
            return this.$store.getters.getPutUpdateUserStatus;
        }
    },
    methods:{
        //用户更新提交函数
        updateProfile(){
            this.$store.dispatch('editUser',{
                favorite_coffee:this.favorite_coffee,
                flavor_note:this.flavor_note,
                profile_visibility:this.profile_visibility,
                city:this.city,
                state:this.state
            });
        },
        //设置页面控件值
        setFileds(){
            this.favorite_coffee = this.user.favorite_coffee;
            this.flavor_note = this.user.flavor_note;
            this.profile_visibility = this.user.profile_visibility;
            this.city = this.user.city;
            this.state = this.user.state;
        }
    },
    created(){
        if(this.userLoadStatus === 2){
            this.setFileds();
        }
    },
    watch:{
        'userLoadStatus':function(){
            if(this.userLoadStatus === 2){
                this.setFileds();
            }
        },
        'putUserUpdateStatus':function(){
            if(this.putUserUpdateStatus === 2){
                $('#profile-updated-successfully').show().delay(5000).fadeOut();
            }
        }
    }
}
</script>
