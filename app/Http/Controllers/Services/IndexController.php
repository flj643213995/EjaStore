<?php
namespace App\Http\Controllers\Services;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use App\Entities\Products;
use App\Entities\Carousel;
use App\MyClasses\Re2Page;
use App\MyClasses\StatusMessage;
use App\Http\Controllers\EjaConstants;

class IndexController extends Controller{
	function IndexProductList(Request $request){
		$re2Page = new Re2Page();
		//记录要跳过的记录条数，第二页要跳过第一页的记录，所以要减一
		if(isset($request -> page)){
			if( $request->page <= 1 ){
				$skipnum=0;
			}else{
				$skipnum = ($request->page-1) * (EjaConstants::INDEX_PRODUCT_LIST_NUM) + 2;	
			}
			$products=DB::table('products')->skip($skipnum)->take(EjaConstants::INDEX_PRODUCT_LIST_NUM)->get();
			$pdtNum = count($products);
			if( 0 == $pdtNum ){
				$re2Page->statusId = 1;
				$re2Page->statusMsg = 0;
				$re2Page->result = 0;	
			}else{
				$re2Page->statusId = 0;
				$re2Page->statusMsg = $pdtNum;
				$re2Page->result = $products;
			}
		}else{
			$re2Page->statusId = -1;
			$re2Page->statusMsg = 0;
			$re2Page->result = 0;
		}
		return $re2Page->toJson();

	}
}
