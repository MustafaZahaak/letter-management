<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    protected $services = array(

        array(
            'dari_name' => 'آزان', 
            'english_name' =>"Azan",
            'pashto_name' =>"Azan",
            "english_desc" => "Get Azan Updates Here",
            "dari_desc" => "برای  دریافت اوقات آزان",
            "pashto_desc" => "د اذان تازه معلومات ترلاسه کړئ",
            "image" => "assets/img/services/azan.jpeg",
            "status" => 'active',
            "type" => '{"type" : "Services Types Here"}'
        ),

        array(
            'dari_name' => 'اخبار', 
            'english_name' =>"Emergeny NEWS",
            'pashto_name' =>"Emergeny NEWS",
            "english_desc" => "Get NEWS Updates Here",
            "dari_desc" => "معلومات جدید اخبار را از اینجا دریافت کنید",
            "pashto_desc" => "دلته تازه خبرونه ترلاسه کړئ",
            "image" => "assets/img/services/news.jpeg",
            "status" => 'active',
            "type" => '{"type" : "Services Types Here"}'
        ),

        array(
            'dari_name' => 'تبادله اسعار', 
            'english_name' =>"Currency Exchange",
            'pashto_name' =>"Currency Exchange",
            "english_desc" => "Get Currency Exchange Updates Here",
            "pashto_desc" => "دلته د اسعارو تبادلې تازه معلومات ترلاسه کړئ",
            "dari_desc" => "معلومات جدید تبادله اسعار را از اینجا دریافت کنید",
            "image" => "assets/img/services/currency.jpeg",
            "status" => 'active',
            "type" => '{"type" : "Services Types Here"}'
        ),

        array(
            'dari_name' => 'آب و هوا', 
            'english_name' =>"Weather",
            'pashto_name' =>"Weather",
            "english_desc" => "Get Weather Latest Updates",
            "dari_desc" => "دریافت آخرین به روز رسانی آب و هوا",
            "pashto_desc" => "د هوا وروستي تازه معلومات ترلاسه کړئ",
            "image" => "assets/img/services/weather.jpeg",
            "status" => 'active',
            "type" => '{"type" : "Services Types Here"}'
        ),

        array(
            'dari_name' => 'کمک های اولیه', 
            'english_name' =>"First Aid",
            'pashto_name' =>"First Aid",
            "english_desc" => "Get First Aid Updates Here",
            "dari_desc" => "به روز رسانی کمک های اولیه را از اینجا دریافت کنید",
            "pashto_desc" => "دلته د لومړنۍ مرستې تازه معلومات ترلاسه کړئ",
            "image" => "assets/img/services/first-aids.jpeg",
            "status" => 'active',
            "type" => '{"type" : "Services Types Here"}'
        ),

        array(
            'dari_name' => 'اسلامی', 
            'english_name' =>"Islamic",
            'pashto_name' =>"Islamic",
            "english_desc" => "Get Islamic Updates Here",
            "pashto_desc" => "دلته اسلامي معلومات ترلاسه کړئ",
            "dari_desc" => "به روز رسانی های اسلامی را از اینجا دریافت کنید",
            "image" => "assets/img/services/islamic.jpeg",
            "status" => 'active',
            "type" => '{"type" : "Services Types Here"}'
        ),

        array(
            'dari_name' => 'کشاورزی', 
            'english_name' =>"Farming",
            'pashto_name' =>"کرنه",
            "english_desc" => "Agriculture and Economic Growth",
            "pashto_desc" => "کرنه او اقتصادي وده",
            "dari_desc" => "کشاورزی و رشد اقتصادی",
            "image" => "assets/img/services/farming.jpeg",
            "status" => 'active',
            "type" => '{"type" : "Services Types Here"}'
        ),


    );
    public function run()
    {
        foreach ($this->services as $ser) :
            $permission = \App\Models\Service::where(['dari_name' => $ser['dari_name'], 'english_name' => $ser['english_name'], 'pashto_name' => $ser['pashto_name']])->first();
            if (!$permission) :
                DB::table('services')->insert($ser);
            endif;
        endforeach;
    }
}
