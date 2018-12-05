/**
 * VUEX modules/cafes.js
 * 这里用来存储单点数据
 */

 import CafeAPI from '../api/cafe.js';
 export const cafes = {
    state:{
        cafes:[],
        cafesLoadStatus: 0,
        cafe:{},
        cafeLoadStatus: 0,
        cafeAddStatus: 0,
        cafeLikeActionStatus:0,
        cafeUnLikeActionStatus:0,
        cafeLiked:false
    },
    
    actions:{
        loadCafes({commit}){
            commit('setCafesLoadStatus', 1);

            CafeAPI.getCafes()
            .then(function(response){
                commit('setCafes', response.data);
                commit('setCafesLoadStatus', 2);     
            })
            .catch(function(){
                commit('setCafes', []);
                commit('setCafesLoadStatus', 3)
            })
        },
        loadCafe({commit}, data){
            commit('setCafeLoadStatus', 1);

            CafeAPI.getCafe(data.id)
            .then(function(response){
                commit('setCafe', response.data);
                console.log(response.data);
                if(response.data.user_like.length > 0){
                    commit('setCafeLikedStatus',true);
                }
                commit('setCafeLoadStatus', 2);
            })
            .catch(function(){
                commit('setCafe', {});
                commit('setCafeLoadStatus', 3);
            });
        },
        addCafe({commit, state, dispatch}, data){
            //状态1标识新增开始
            commit('setCafeAddStatus', 1);
            CafeAPI.postAddNewCafe(data.name, data.locations, data.website, data.description, data.roaster,data.picture)
                   .then(function(response){
                        commit('setCafeAddStatus', 2);
                        dispatch('loadCafes');
                   })
                   .catch(function(){
                        commit('setCafeAddStatus', 3);
                   });

        },
        likeCafe({commit,state},data){
            commit('setCafeLikeActionStatus',1);
            CafeAPI.postLikeCafe(data.id)
                   .then(function(response){
                        commit('setCafeLikedStatus',true);
                        commit('setCafeLikeActionStatus',2);
                   })
                   .catch(function(){
                        commit('setCafeLikeActionStatus',3);
                   });
        },
        unlikeCafe({commit,state},data){
            commit('setCafeUnLikeActionStatus',1);
            CafeAPI.deleteLikeCafe(data.id)
                   .then(function(response){
                        commit('setCafeLikedStatus',false);
                        commit('setCafeUnLikeActionStatus',2);
                   })   
                   .catch(function(){
                        commit('setCafeUnLikeActionStatus',3);
                   });
        }
    },
    mutations:{
        setCafesLoadStatus(state, status){
            state.cafesLoadStatus = status;
        },
        setCafes(state, cafes){
            state.cafes = cafes;
        },
        setCafeLoadStatus(state, status){
            state.cafeLoadStatus = status;
        },
        setCafe(state, cafe){
            state.cafe = cafe;
        },
        setCafeAddStatus(state, status){
            state.cafeAddStatus = status;
        },
        setCafeLikeActionStatus(state,status){
            state.cafeLikeActionStatus = status;
        },
        setCafeUnLikeActionStatus(state,status){
            state.cafeUnLikeActionStatus = status;
        },
        setCafeLikedStatus(state,status){
            state.cafeLiked = status;
        }
    },
    getters:{
        getCafesLoadStatus(state){
            return state.cafesLoadStatus;
        },
        getCafes(state){
            return state.cafes;
        },
        getCafeLoadStatus(state){
            return state.cafeLoadStatus;
        },
        getCafe(state){
            return state.cafe;
        },
        getCafeAddStatus(state){
            return state.cafeAddStatus;
        },
        getCafeLikeActionStatus(state){
            return state.cafeLikeActionStatus;
        },
        getCafeUnLikeActionStatus(state){
            return state.cafeUnLikeActionStatus;
        },
        getCafeLikedStatus(state){
            return state.cafeLiked;
        }
    }
 };
