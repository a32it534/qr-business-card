<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Business extends Model {
    use HasFactory;
    protected $fillable=['user_id','category_id','name','slug','public_code','description','mobile','phone','telegram','instagram','rubika','website','address','latitude','longitude','logo','status'];

    protected static function booted(){
        static::creating(function($m){
            $m->public_code=strtoupper(Str::random(8));
            $m->slug=Str::slug($m->name).'-'.strtolower(Str::random(5));
        });
    }

    public function user(){return $this->belongsTo(User::class);}
    public function category(){return $this->belongsTo(BusinessCategory::class,'category_id');}
    public function scans(){return $this->hasMany(ScanStatistic::class);}
    public function getPublicUrlAttribute(){return route('business.public',$this->public_code);}

    public function setTelegramAttribute($value){$this->attributes['telegram']=self::socialUrl($value,'https://telegram.me/');}
    public function setInstagramAttribute($value){$this->attributes['instagram']=self::socialUrl($value,'https://instagram.com/');}
    public function setRubikaAttribute($value){$this->attributes['rubika']=self::socialUrl($value,'https://rubika.ir/');}

    private static function socialUrl($value,string $base): ?string {
        $value=trim((string)$value);
        if($value==='') return null;
        if(preg_match('/^https?:\/\//i',$value)) return $value;
        $value=ltrim($value,'@/');
        return $base.rawurlencode($value);
    }
}
