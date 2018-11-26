export const CafesIsRoasterFilter = {
    methods:{
        //筛选咖啡店是否是烘焙店
        processCafeIsRosterFilter(cafe){
            if(cafe.roaster === 1){
                return true;
            }else{
                return false;
            }
        }
    }
}