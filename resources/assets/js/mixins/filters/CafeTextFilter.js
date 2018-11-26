export const CafeTextFilter = {
   methods:{
       //文本过滤函数过滤咖啡店的名称,位置名称，地址，城市
       processCafeTextFliter(cafe,text){
            if(text.length > 0){
                if(cafe.name.toLowerCase().match('[^,]*' + text.toLowerCase() + '[,$]*')
                    || cafe.location_name.toLowerCase().match('[^,]*' + text.toLowerCase() + '[,$]*')
                    || cafe.address.toLowerCase().match('[^,]*' + text.toLowerCase() + '[,$]*')
                    || cafe.city.toLowerCase().match('[^,]*' + text.toLowerCase() + '[,$]*')){
                        return true;
                }else{  
                        return false;
                }
            }else{
                return true;
            }
       }
   } 
}