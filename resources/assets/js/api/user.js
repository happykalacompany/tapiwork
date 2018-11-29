import {TAPIWORK_CONFIG} from '../config.js';
import Axios from 'axios';

export default{

    /**
     * 获取当前登录用户的信息
     * get /api/v1/user
     */
    getUser:function(){
        return Axios.get(TAPIWORK_CONFIG.API_URL+'/user');
    },

    /**
     * 更新当前登录用户的信息
     * put /api/v1/user
     */
    putUpdateUser:function(favorite_coffee,flavor_note,profile_visibility,city,state){
        Axios.put(TAPIWORK_CONFIG.API_URL+'/user',{
            favorite_coffee:favorite_coffee,
            flavor_note:flavor_note,
            profile_visibility:profile_visibility,
            city:city,
            state:state
        })
    }
}