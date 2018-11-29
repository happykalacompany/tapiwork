/**
 * VUEX modules/user.js
 * 这里用来存储单点数据
 */
import UserApI from '../api/user.js';
export const user = {
    state:{
        user:{},
        userLoadStatus:0
    },
    actions:{
        loadUser({commit}){
            commit('setUserLoadStatus',1);
            UserApI.getUser()
            .then(function(response){
                commit('setUser',response.data);
                commit('setUserLoadStatus',2);
            })
            .catch(function(){
                commit('setUserLoadStatus',3);
            })
        }
    },
    mutations:{
        setUser(state,user){
            state.user = user;
        },
        setUserLoadStatus(state,status){
            state.userLoadStatus = status;
        }
    },
    getters:{
        getUser(state){
            return state.user;
        },
        getUserLoadStatus(state){
            return state.userLoadStatus;
        }
    }
}