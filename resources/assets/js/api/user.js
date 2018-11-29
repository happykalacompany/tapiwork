import {TAPIWORK_CONFIG} from '../config.js';
import Axios from 'axios';

export default{

    /**
     * 获取当前登录用户的信息
     * get /api/v1/user
     */
    getUser:function(){
        return Axios.get(TAPIWORK_CONFIG.API_URL+'/user');
    }

}