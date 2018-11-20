<style lang="scss">
    @import '~@/abstracts/_variables.scss';
    span.toggle-like{
        text-align: center;
        display: block;
        margin-top: 20px;
        text-decoration: underline;

        &.like{
            cursor: pointer;
        }
        &.unlike{
            cursor: pointer;
        }
    }
</style>

<template>
    <span class="toggle-like">
        <span class="like" v-on:click="like(cafe.id)" v-if="!cafeLike && cafeLoadStatus === 2 && cafeLikeActionStatus != 1 
        && cafeUnLikeActionStatus != 1">
            喜欢
        </span>
        <span class="unlike" v-on:click="unlike(cafe.id)" v-if="cafeLike && cafeLoadStatus === 2 && cafeLikeActionStatus != 1 
        && cafeUnLikeActionStatus != 1">
            取消喜欢
        </span>
        <loader v-show="cafeLikeActionStatus === 1 || cafeUnLikeActionStatus === 1" :width="30" :height="30" :display="'inline-block'"></loader>
    </span>
</template>

<script>
import Loader from '../global/Loader.vue';
export default {
    components:{
        Loader
    },
    computed:{
        cafeLoadStatus(){
            return this.$store.getters.getCafeLoadStatus;
        },
        cafe(){
            return this.$store.getters.getCafe;
        },
        cafeLike(){
            return this.$store.getters.getCafeLikedStatus;
        },
        cafeLikeActionStatus(){
            return this.$store.getters.getCafeLikeActionStatus;
        },
        cafeUnLikeActionStatus(){
            return this.$store.getters.getCafeUnLikeActionStatus;
        }
    },
    methods:{
        like(cafeID){
            this.$store.dispatch('likeCafe',{
                id:cafeID
            });
        },
        unlike(cafeID){
            this.$store.dispatch('unlikeCafe',{
                id:cafeID
            });
        }
    }
}
</script>
