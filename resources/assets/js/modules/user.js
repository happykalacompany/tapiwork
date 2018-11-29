/**
 * VUEX modules/user.js
 * 这里用来存储单点数据
 */
import UserApI from '../api/user.js';
export const user = {
    state:{
        user:{},
        userLoadStatus:0,
        putUpdateUserStatus:0
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
        },
        editUser({commit,state,dispatch},data){
            commit('setPutUpdateUserStatus',1);
            UserApI.putUpdateUser(data.favorite_coffee,data.flavor_note,data.profile_visibility,data.city,data.state)
            .then(function(){
                commit('setPutUpdateUserStatus',2);
                dispatch('loadUser');   
            })
            .catch(function(){
                commit('setPutUpdateUserStatus',3);  
            }) 
        }
    },
    mutations:{
        setUser(state,user){
            state.user = user;
        },
        setUserLoadStatus(state,status){
            state.userLoadStatus = status;
        },
        setPutUpdateUserStatus(state,status){
            state.putUpdateUserStatus = status;
        }
    },
    getters:{
        getUser(state){
            return state.user;
        },
        getUserLoadStatus(state){
            return function(){
                return state.userLoadStatus;
            }
        },
        getPutUpdateUserStatus(state){
            return state.putUpdateUserStatus;
        }
    }
}