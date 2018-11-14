import { TAPIWORK_CONFIG } from '../config.js'
import Axios from 'axios';

export default{
    /**
     * 获取所有的cafes店的数据
     * get /api/v1/cafes
     */
    getCafes: function(){
        return Axios.get(TAPIWORK_CONFIG.API_URL+ '/cafes')
    },
    /**
     * 获取具体的cafe店的信息
     * get /api/v1/cafe/{cafeId}
     */
    getCafe: function(cafeId){
        return Axios.get(TAPIWORK_CONFIG.API_URL+ '/cafe/' + cafeId)
    },
    /**
     * 新增一个cafe店
     * post /api/v1/cafes
     */
    postAddNewCafe: function(name,locations,website,description,roaster){
        return Axios.post(TAPIWORK_CONFIG.API_URL+ '/cafes',{
            name:name,
            locations:locations,
            website:website,
            description:description,
            roaster:roaster
        })
    }
}