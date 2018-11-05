<?php
namespace app\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreCafeRequest;
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
        $cafes = Cafe::all();
        return response()->json($cafes);
    }

    /**
     * url: /api/v1/cafe/{id}
     * method: get
     * description: get a cafe detail
     */
    public function getCafe($id){
        $cafe = Cafe::where('id','=',$id)->first();
        return response()->json($cafe);
    }

    /**
     * url: /api/v1/cafes
     * method: post
     * description: add new cafe
     */
    public function postNewCafe(StoreCafeRequest $request){
        $cafe = new Cafe();
        $cafe->name = $request->input('name');
        $cafe->address = $request->input('address');
        $cafe->city = $request->input('city');
        $cafe->state = $request->input('state');
        $cafe->zip = $request->input('zip');
        $cafe->latitude = 0;
        $cafe->longtitude = 0;

        $cafe->save();

        return response()->json($cafe, 201);
    }
}