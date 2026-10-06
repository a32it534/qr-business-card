<?php
namespace App\Http\Controllers;
use App\Models\Business;
use App\Models\ScanStatistic;
use Illuminate\Http\Request;
class PublicBusinessController extends Controller { public function show(Request $r,string $code){$b=Business::with('category')->where('public_code',strtoupper($code))->where('status','active')->firstOrFail(); $ua=$r->userAgent()??''; $device=preg_match('/mobile|android|iphone/i',$ua)?'mobile':'desktop'; ScanStatistic::create(['business_id'=>$b->id,'ip_hash'=>hash('sha256',$r->ip().'|'.$b->id),'user_agent'=>substr($ua,0,500),'device_type'=>$device]); return view('business.public',compact('b'));} }
