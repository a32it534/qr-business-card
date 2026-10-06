<?php
namespace App\Http\Controllers;
use App\Models\Business;
use App\Models\BusinessCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

class BusinessController extends Controller {
    private function own(Business $b){abort_unless($b->user_id===auth()->id(),403);}
    public function index(){ $businesses=auth()->user()->businesses()->with('category')->withCount('scans')->latest()->get(); return view('dashboard.index',compact('businesses')); }
    public function create(){ $categories=BusinessCategory::orderBy('name')->get(); return view('dashboard.business-form',compact('categories')); }
    public function store(Request $r){$d=$this->validateData($r); if($r->hasFile('logo')){$d['logo']=$r->file('logo')->store('logos','public');}$d['user_id']=auth()->id();$b=Business::create($d);return redirect()->route('dashboard.business.qr',$b)->with('success','کسب‌وکار با موفقیت ایجاد شد.');}
    public function edit(Business $business){$this->own($business);$categories=BusinessCategory::orderBy('name')->get();return view('dashboard.business-form',compact('business','categories'));}
    public function update(Request $r,Business $business){$this->own($business);$d=$this->validateData($r);if($r->hasFile('logo')){if($business->logo) Storage::disk('public')->delete($business->logo);$d['logo']=$r->file('logo')->store('logos','public');}$business->update($d);return redirect()->route('dashboard.index')->with('success','اطلاعات به‌روزرسانی شد.');}
    public function destroy(Business $business){
        $this->own($business);
        if($business->logo) Storage::disk('public')->delete($business->logo);
        $business->delete();
        return redirect()->route('dashboard.index')->with('success','کسب‌وکار و QR آن با موفقیت حذف شد.');
    }
    private function validateData(Request $r){return $r->validate(['name'=>'required|string|max:150','category_id'=>'nullable|exists:business_categories,id','description'=>'nullable|string|max:3000','mobile'=>'nullable|string|max:30','phone'=>'nullable|string|max:30','telegram'=>'nullable|string|max:255','instagram'=>'nullable|string|max:255','rubika'=>'nullable|string|max:255','website'=>'nullable|url|max:255','address'=>'nullable|string|max:1000','latitude'=>'nullable|numeric','longitude'=>'nullable|numeric','logo'=>'nullable|image|max:2048']);}
    public function qr(Business $business){
        $this->own($business);
        $qr=new QrCode(data:$business->publicUrl,encoding:new Encoding('UTF-8'),errorCorrectionLevel:ErrorCorrectionLevel::Low,size:700,margin:20);
        $result=(new PngWriter())->write($qr);
        $qrDataUri='data:image/png;base64,'.base64_encode($result->getString());
        return view('dashboard.qr',compact('business','qrDataUri'));
    }
    public function qrDownload(Business $business){$this->own($business);$qr=new QrCode(data:$business->publicUrl,encoding:new Encoding('UTF-8'),errorCorrectionLevel:ErrorCorrectionLevel::Low,size:900,margin:20);$result=(new PngWriter())->write($qr);return response($result->getString(),200,['Content-Type'=>'image/png','Content-Disposition'=>'attachment; filename="'.$business->public_code.'.png"']);}
}
