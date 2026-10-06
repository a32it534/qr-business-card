<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ScanStatistic extends Model { protected $fillable=['business_id','ip_hash','user_agent','device_type']; public function business(){return $this->belongsTo(Business::class);} }
