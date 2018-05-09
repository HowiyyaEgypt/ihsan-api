<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $govs = [

            'ar' => [
                1 => 'القاهرة',
                2 => 'الشرقية',
                3 => 'الدقهلية',
                4 => 'البحيرة',
                5 => 'الجيزة',
                6 => 'المنيا',
                7 => 'أسيوط',
                8 => 'القليوبية',
                9 => 'الإسكندرية',
                10 => 'الغربية',
                11 => 'سوهاج',
                12 => 'المنوفية',
                13 => 'أسوان',
                14 => 'كفر الشيخ',
                15 => 'الفيوم',
                16 => 'قنا',
                17 => 'بني سويف',
                18 => 'دمياط',
                19 => 'الإسماعيلية',
                20 => 'مطروح',
                21 => 'شمال سيناء',
                22 => 'الوادي الجديد',
                23 => 'البحر الأحمر',
                24 => 'الأقصر',
                25 => 'بورسعيد',
                26 => 'السويس',
                27 => 'جنوب سيناء'
            ],
    
            'en' => [
                1 => 'Cairo',
                2 => 'Alsharkia',
                3 => 'Aldkahlia',
                4 => 'Albhera',
                5 => 'Algiza',
                6 => 'Almnia',
                7 => 'Assuit',
                8 => 'Alkalubia',
                9 => 'Alexandria',
                10 => 'Algharbia',
                11 => 'Sohag',
                12 => 'Almnofia',
                13 => 'Aswan',
                14 => 'Kafr elsheikh',
                15 => 'Alfyoum',
                16 => 'Qena',
                17 => 'Bani Sweif',
                18 => 'Damietta',
                19 => 'Alismailia',
                20 => 'Matrouh',
                21 => 'North Sinai',
                22 => 'Alwady algaded',
                23 => 'The Red Sea',
                24 => 'Luxor',
                25 => 'Portsaid',
                26 => 'Suez',
                27 => 'South Sinai'
            ]
    
        ];

        $govs_length = count($govs['ar']);

        for ($i = 1; $i < $govs_length +1 ; $i++) {
            \App\City::create(['name_ar' => $govs['ar'][$i], 'name_en' => $govs['en'][$i]]);
        }
    
    }
}
