<?php
namespace app\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Utilities\GaodeMaps;
use App\Utilities\Tagger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreCafeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @abstract 咖啡店的操作控制器类
 * 
 */
class CafesController extends Controller{

    /**
     * url: /api/v1/cafes
     * method: get
     * description: get all cafes in the application
     */
    public function getCafes(){
        $cafes = Cafe::with('brewMethods')->get();
        return response()->json($cafes);
    }

    /**
     * url: /api/v1/cafe/{id}
     * method: get
     * description: get a cafe detail
     */
    public function getCafe($id){
        $cafe = Cafe::where('id','=',$id)->with('brewMethods')->with('userLike')->first();
        return response()->json($cafe);
    }

    /**
     * url: /api/v1/cafes
     * method: post
     * description: add new cafe
     */
    public function postNewCafe(StoreCafeRequest $request){

        //已经添加的咖啡店的数据
        $addedCafes = [];

        //存储咖啡店的总店位置
        $parentCafe = new Cafe();
        $parentCafe->name = $request->input('name');
        //获取所有的咖啡店的位置信息
        $locations = $request->input('locations');
        $parentCafe->location_name = $locations[0]['name']?:'';
        $parentCafe->address = $locations[0]['address']?:'';
        $parentCafe->city = $locations[0]['city']?:'';
        $parentCafe->state = $locations[0]['state']?:'';
        $parentCafe->zip = $locations[0]['zip']?:'';
        $arrLocation = GaodeMaps::geocodeAddress($parentCafe->address, $parentCafe->city, $parentCafe->state);
        $parentCafe->latitude = $arrLocation['latitude'];
        $parentCafe->longtitude = $arrLocation['longtitude'];
        $parentCafe->roaster = $request->input('roaster')?1:0;
        $parentCafe->website = $request->input('website');
        $parentCafe->description = $request->input('description');
        $parentCafe->added_by = $request->user()->id;
        $parentCafe->parent = 0;
        $parentCafe->save();

        //获取总点的冲泡方法并和总店数据关联
        $brewMethods = $locations[0]['methodsAvailable'];
        $parentCafe->brewMethods()->sync($brewMethods);
        array_push($addedCafes,$parentCafe->toArray());

        //存储分店的上传信息,locations长度大于1的情况下说明存在分点
        if(count($locations) > 1){
            for($i=1;$i<count($locations);$i++){
                //分店与总店公用的信息有名称，网址，描述
                $cafe = new Cafe();
                $cafe->parent = $parentCafe->id;
                $cafe->name = $request->input('name');
                $cafe->location_name = $locations[$i]['name']?:'';
                $cafe->address = $locations[$i]['address'];
                $cafe->city = $locations[$i]['city'];
                $cafe->state = $locations[$i]['state'];
                $cafe->zip = $locations[$i]['zip'];
                $coordinates = GaodeMaps::geocodeAddress($cafe->address,$cafe->city,$cafe->state);
                $cafe->latitude = $coordinates['latitude'];
                $cafe->longtitude = $coordinates['longtitude'];
                $cafe->roaster = $request->input('roaster')?1:0;
                $cafe->website = $request->input('website');
                $cafe->description = $request->input('description');
                $cafe->added_by = $request->user()->id;
                $cafe->save();
                $cafe->brewMethods()->sync($locations[$i]['methodsAvailable']);
                array_push($addedCafes,$cafe->toArray());
            }
        }
        return response()->json($addedCafes, 201);
    }

    /**
     * url:/api/v1/cafes/{id}/like
     * method:post
     * description: save cafe like data
     */
    public function postLikeCafe($cafeID){
        $cafe = Cafe::where('id','=',$cafeID)->first();
        $cafe->likes()->attach(Auth::user()->id,
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        return response()->json(['cafe_liked' => true],201);
    }

    /**
     * url:/api/v1/cafes/{id}/like
     * method:delete
     * description:delete cafe like data
     */
    public function deleteLikeCafe($cafeID){
        $cafe = Cafe::where('id','=',$cafeID)->first();
        $cafe->likes()->detach(Auth::user()->id);
        return response()->json(null,204);
    }

    /**
     * url:/api/v1/cafe/{id}/tags
     * method:post
     * description:add cafe tags
     */
    public function postAddTags(Request $request,$cafe_id){
        //获取请求从传递的标签数据
        $tags = $request->input('tags');
        $cafe = Cafe::find($cafe_id);
        //处理标签和咖啡店之间的关联
        Tagger::tagsCafe(Auth::user()->id,$tags,$cafe);
        //获取标签关联之后的cafe点数据
        $cafe = Cafe::where('id','=',$cafe_id)->with('brewMethods')->with('userLike')->with('Tags')->first();
        return response()->json($cafe,201);
    }


    /**
     * url:/api/v1/cafe/{id}/tags/{tagId}
     * method:delete
     * description:delete cafe tags
     */
    public function deleteCafeTags($cafeid,$tagid){
        DB::table('cafes_users_tags')->where('cafe_id','=',$cafeid)->where('tag_id','=',$tagid)
            ->where('user_id',Auth::user()->id)->delete();
        return response()->json('null',204);
    }
}