<style>

</style>

<template>
    <div id="home">
        <span v-show="cafesLoadStatus == 1">Loading.....</span>
        <span v-show="cafesLoadStatus == 2">Cafes Data Loaded Successfully!</span>
        <span v-show="cafesLoadStatus == 3">Cafes Dara Loaded unSuccessfully!</span>
    </div>    
</template>

<script>
export default {
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
        }
    }

    
}
</script>