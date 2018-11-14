<style lang="scss">
   div#cafe-map{
       width: 100%;
       height: 400px;
   }
</style>
<template>
    <div id='cafe-map'>
        
    </div>
</template>
<script>
import { TAPIWORK_CONFIG } from '../../config.js';
export default {
    props:{
        'latitude':{
            type:Number,
            default:function(){
                return 120.21;
            }
        },
        'longtitude':{
            type:Number,
            default:function(){
                return 30.29;
            }
        },
        'zoom':{
            type:Number,
            default:function(){
                return 4;
            }
        }
    },
    data(){
        return {
            //初始化地图上的标记点数组
            markers:[],
            //初始化地图上的标记点信息窗体
            InfoWindows:[]
        }
    },
    mounted(){
        this.map = new AMap.Map('cafe-map',{
            zoom:this.zoom,
            center:[this.latitude, this.longtitude],
        });
        this.clearMarkers();
        this.buildMarkers();
    },
    computed:{
        //计算属性获取到单一节点数据中的咖啡店的数据
        cafes(){
            return this.$store.getters.getCafes;
        }
    },
    methods:{
        //标记地图上的点
        buildMarkers(){
            //自定义点标记的图标
            var image = TAPIWORK_CONFIG.APP_URL + '/storage/img/coffee-marker.png';
            var icon = new AMap.Icon({
                image:image,
                imageSize: new AMap.Size(19,33)
            });
            //首先清空标记点
            this.markers = [];
            //循环所有的咖啡店的数据填充到标记数组markers中
            for(var i=0;i<this.cafes.length;i++){
                //创建一个点标记
                var marker = new AMap.Marker({
                    position: new AMap.LngLat(parseFloat(this.cafes[i].latitude), parseFloat(this.cafes[i].longtitude)),  
                    title: this.cafes[i].location_name,
                    icon:icon
                });
                //创建一个新的信息窗体
                var infoWindow = new AMap.InfoWindow({
                    content:this.cafes[i].location_name
                });
                this.InfoWindows.push(infoWindow);
                //将窗体和标记点的点击事件绑定起来
                marker.on('click',function(){
                    infoWindow.open(this.getMap(),this.getPosition());
                });

                //将生成的标记点放置到标记数组中
                this.markers.push(marker);    
            }
            //将标记点显示在地图中
            this.map.add(this.markers);
        },
        //清除地图上的点
        clearMarkers(){
            for(var i=0;i<this.markers.length;i++){
                this.markers[i].setMap(null);
            }
        }
    },
    watch:{
        //监听cafes的变化，一旦数据变化了就刷新标记点
        cafes(){
            this.clearMarkers();
            this.buildMarkers();
        }
    }
}
</script>
