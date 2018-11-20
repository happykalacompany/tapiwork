<style lang="scss">
    @import 'resources/assets/sass/abstracts/_variables.scss';

    div#individual-cafe-map{
        width: 700px;
        height: 500px;
        margin: auto;
        margin-bottom: 200px;
    }

</style>

<template>
    <div id="individual-cafe-map">

    </div>
</template>

<script>

//引入配置文件后面在生成地图获取自定义图标的时候需要用到预定义好的物理路径
import {TAPIWORK_CONFIG} from '../../config.js';

export default {
    computed:{
        //计算属性获取到当前要加载的cafe的数据和加载状态
        cafeLoadStatus(){
            return this.$store.getters.getCafeLoadStatus;
        },
        cafe(){
            return this.$store.getters.getCafe;
        }
    },
    watch:{
        //监听加载状态数据以便调用地图显示方法
        cafeLoadStatus(){
            //数据获取成功
            if(this.cafeLoadStatus === 2){
                this.displayIndividualCafeMap();
            }
        }
    },
    methods:{
        //页面地图绘制方法
        displayIndividualCafeMap(){
            //绘制地图
            this.map = new AMap.Map('individual-cafe-map',{
                zoom:13,
                center:[parseFloat(this.cafe.latitude),parseFloat(this.cafe.longtitude)]
            });

            //自定义显示图标
            var image = TAPIWORK_CONFIG.APP_URL + '/storage/img/coffee-marker.png';
            var icon = new AMap.Icon({
                image:image,
                imageSize: new AMap.Size(19,33)
            });

            //定义标记点
            var marker = new AMap.Marker({
                position:new AMap.LngLat(parseFloat(this.cafe.latitude),parseFloat(this.cafe.longtitude)),
                icon:icon
            });

            //将标记点增加到地图上
            this.map.add(marker);
        }
    }
}
</script>
