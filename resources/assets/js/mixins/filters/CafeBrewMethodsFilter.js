export const CafeBrewMethodsFilter = {
    methods:{
        //根据冲调方法来筛选现有的咖啡店数据
        processCafeBrewMethodsFilter(cafe,BrewMethods){
            if(BrewMethods.length > 0){
                var cafeBrewMethods = [];
                //将当前咖啡的冲调方法填充到预先定于好的数组中
                for(var i=0;i<cafe.brew_methods.length;i++){
                    cafeBrewMethods.push(cafe.brew_methods[i].method);
                }
                //遍历循环填充好的冲调方法和传递的冲调方法做比对
                for(var i=0;i<BrewMethods.length;i++){
                    if(cafeBrewMethods.indexOf(BrewMethods[i]) > -1){
                        return true;
                    }
                }
                return false;
            }else{
                return true;
            }
        }
    }
}