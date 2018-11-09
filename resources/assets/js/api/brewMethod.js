import { TAPIWORK_CONFIG } from '../config.js';
import Axios from 'axios';

export default{

    /**
     * 获取所有的冲调方法和当前方法下对应的咖啡店的数量
     * /api/v1/brew_methods
     */
    getBrewMethods: function(){
        return Axios.get(TAPIWORK_CONFIG.API_URL + '/brew_methods');
    }
}