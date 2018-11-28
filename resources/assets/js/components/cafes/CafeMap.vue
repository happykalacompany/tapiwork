<style lang="scss">
   div#cafe-map-container{
       position: absolute;
       top: 50px;
       right: 0px;
       left: 0px;
       bottom: 50px;

       div#cafe-map{
           position: absolute;
           top: 0px;
           right: 0px;
           left:0px;
           bottom: 0px;
       }
   }
</style>
<template>
    <div id="cafe-map-container">
        <div id='cafe-map'>
        
        </div>
        <cafe-map-filter></cafe-map-filter>
    </div>
</template>
<script>
import { TAPIWORK_CONFIG } from '../../config.js';
import CafeMapFilter from './CafeMapFilter.vue';
import { EventBus } from '../../event-bus.js';
import { CafeBrewMethodsFilter } from '../../mixins/filters/CafeBrewMethodsFilter.js';
import { CafesIsRoasterFilter } from '../../mixins/filters/CafeIsRoasterFilter.js';
import { CafeTextFilter } from '../../mixins/filters/CafeTextFilter.js';
export default {
    components:{
        CafeMapFilter
    },
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
    mixins:[
        CafeTextFilter,
        CafesIsRoasterFilter,
        CafeBrewMethodsFilter
    ],
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

        //监听筛选条件的变化显示隐藏现在的地图控制点
        EventBus.$on('filters-updated',function(filters){
            this.processFilterData(filters);
        }.bind(this));


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
                    icon:icon,
                    extData:{
                        'cafe':this.cafes[i]
                    }
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
        },
        processFilterData(filters){
            //循环makers点做条件判断处理
            for(var i=0;this.markers.length;i++){
                var textPass = false;
                var tagsPass = false;
                var isRoasterPass = false;
                var brewMethodsPass = false;
                if(filters.text === '' 
                    && filters.tags.length == 0 
                    && filters.roaster === false
                    && filters.brew_method.length == 0){
                        //所有筛选条件都为空
                        this.markers[i].setMap(this.map);
                }else{
                    console.log(this.markers[i].getExtData( ).cafe);
                    //处理文字筛选
                    if(filters.text !='' && this.processCafeTextFliter(this.markers[i].getExtData( ).cafe,filters.text)){
                        textPass = true;
                    }else if(filters.text == '' ){
                        textPass = true;
                    }
                    //处理烘焙店筛选
                    if(filters.roaster && this.processCafeIsRosterFilter(this.markers[i].getExtData( ).cafe)){
                        isRoasterPass = true;
                    }else if(!filters.roaster){
                        isRoasterPass = true;
                    }
                    //筛选冲调方法筛选
                    if(filters.brew_method.length > 0 && this.processCafeBrewMethodsFilter(this.markers[i].getExtData( ).cafe,filters.brew_method)){
                        brewMethodsPass = true;
                    }else if(filters.brew_method.length == 0){
                        brewMethodsPass = true;
                    }

                    if(textPass && isRoasterPass && brewMethodsPass){
                        this.markers[i].setMap(this.map);
                    }else{
                        this.markers[i].setMap(null);
                    }
                }
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