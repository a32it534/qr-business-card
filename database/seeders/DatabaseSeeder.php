<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;use App\Models\BusinessCategory;
class DatabaseSeeder extends Seeder {public function run(){foreach(['فروشگاه','رستوران و کافه','پوشاک','خدمات فنی','آرایش و زیبایی','پزشکی و سلامت','آموزش','شرکت','سایر'] as $name) BusinessCategory::firstOrCreate(['name'=>$name]);}}
