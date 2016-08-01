<?php
namespace App\Http\Controllers\Views;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Entities\Products;
use App\Entities\Carousel;
use App\Http\Controllers\EjaConstants;
class IndexViewController extends Controller{
	function IndexView(Request $request){
		$carousels = DB::table('carousel')->take(5)->get();
		$recProduct=DB::table('products')->orderBy('soldNumber','desc')->first();
		$relProduct=DB::table('products')->where('brand',$recProduct->brand)->where('id','<>',$recProduct->id)->orderBy('soldNumber','desc')->first();
		if(!isset($relProduct->id)){
			$relProduct=DB::table('products')->orderBy('soldNumber','desc')->skip(1)->take(1)->get()[0];
		}
		if(isset( $request->page )){
			//记录要跳过的记录条数，第二页要跳过第一页的记录，所以要减一
			$skipnum = ($request->page-1) * (EjaConstants::INDEX_PRODUCT_LIST_NUM) + 2;	
			$products=DB::table('products')->whereNotIn('id',[$recProduct->id,$relProduct->id])->skip($skipnum)->take(EjaConstants::INDEX_PRODUCT_LIST_NUM)->get();
		}else{
			$products=DB::table('products')->whereNotIn('id',[$recProduct->id,$relProduct->id])->take(EjaConstants::INDEX_PRODUCT_LIST_NUM)->get();
		
		}
		
		
		return view('test_index')->with('carousels',$carousels)
							->with('recProduct',$recProduct)
							->with('products',$products)
							->with('relProduct',$relProduct);	

	}
}
