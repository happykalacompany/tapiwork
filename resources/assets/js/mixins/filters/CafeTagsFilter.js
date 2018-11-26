export const CafeTagsFilter = {
    methods:{
        //通过标签删除咖啡店的数据
        processCafeTagsFilter(cafe,tags){
            var cafeTags = [];
            if(tags.length > 0){
                //将当前咖啡店中的标签数据填充到新数组中
                for(var i=0;i<cafe.tags.length;i++){
                    cafeTags.push(cafe.tags[i].name);
                }
                //遍历筛选标签和当前咖啡店所拥有的标签匹配
                for(var i=0;i<tags.length;i++){
                    if(cafeTags.indexOf(tags[i]) > -1){
                        return true;
                    }
                }
                //所有标签都不在匹配中的时候返回false
                return false;
            }else{
                return true;
            }
        }
    }
}