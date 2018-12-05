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
    postAddNewCafe: function(name,locations,website,description,roaster,picture){

        let formData = new FormData();
        formData.append('name',name);
        formData.append('locations',JSON.stringify(locations));
        formData.append('website',website);
        formData.append('description',description);
        formData.append('roaster',roaster);
        formData.append('picture',picture);

        return Axios.post(TAPIWORK_CONFIG.API_URL+ '/cafes',
            formData,
            {
                headers:{
                    'Content-Type':'multipart/form-data'
                }
            }
        )
    },
    /**
     * 关注咖啡店
     * post /api/v1/cafes/{cafeID}/like
     */
    postLikeCafe:function(cafeID){
        return Axios.post(TAPIWORK_CONFIG.API_URL+'/cafes/'+cafeID+'/like');
    },
    /**
     * 取消关注咖啡店
     * delete /api/v1/cafes/{cafeID}/like
     */
    deleteLikeCafe:function(cafeID){
        return Axios.delete(TAPIWORK_CONFIG.API_URL+'/cafes/'+cafeID+'/like')
    }

}
