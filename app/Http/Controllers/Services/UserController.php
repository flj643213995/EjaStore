<?php
namespace App\Http\Controllers\Views;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Entities\Users;
use App\Http\Controllers\EjaConstants;
use App\MyClasses\StatusMessage;

class UserController extends Controller{
	function CheckLogin(Request $request){
		$status = new StatusMessage();
		if( empty($request->uName) || empty($request->uPassword ) ){
			$status->statusId = -1;
			$status->statusMsg = '用户名或密码不能为空！';
			return $status->toJson();
		}	
		if( false == strpos($request->uName,'@') ){
			$status->statusId = -2;
			$status->statusMsg = '请输入正确的用户名！';
			return $status->toJson();
		}
		$user = Users::where('username',$request->uName);
		if( empty($user) ){
			$status->statusId = -3;
			$status->statusMsg = '该用户不存在！';
			return status->toJson();
		}
		if($user->password==md5('_eja+'+$request->get('password'))){
			$request->session()->put('user',$user);
			$status->statusId=0;
			$status->statusMsg='登录成功';
			return $status->toJson();
		}else{
			$status->statusId=-4;
			$status->statusMsg='密码错误';
			return $status->toJson();
		}
	}
}
