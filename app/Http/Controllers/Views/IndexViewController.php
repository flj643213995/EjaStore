<?php
namespace App\Http\Controllers\Views;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Entities\Products;
use App\Entities\Carousel;
class IndexViewController extends Controller{
	function IndexView(){
		$carousels = DB::table('carousel')->take(5)->get();
		$recProduct=DB::table('products')->orderBy('soldNumber','desc')->first();
		$relProduct=DB::table('products')->where('brand',$recProduct->brand)->where('id','<>',$recProduct->id)->orderBy('soldNumber','desc')->first();
		if(!isset($relProduct->id)){
			$relProduct=DB::table('products')->orderBy('soldNumber','desc')->skip(1)->take(1)->get()[0];
		}
		$products=DB::table('products')->whereNotIn('id',[$recProduct->id,$relProduct->id])->take(16)->get();

		return view('index')->with('carousels',$carousels)
							->with('recProduct',$recProduct)
							->with('products',$products)
							->with('relProduct',$relProduct);	

	}
}
