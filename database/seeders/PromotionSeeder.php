<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promotions=[
                [
                    'type'=>'basic',
                    'price'=>2.99,
                    'duration'=>24,
                ],
                [
                    'type'=>'medium',
                    'price'=>5.99,
                    'duration'=>72,
                ],
                [
                    'type'=>'premium',
                    'price'=>9.99,
                    'duration'=>144,
                ]
            ];
        foreach($promotions as $singlePromotion){
            $promotion = new Promotion();
            $promotion->type = $singlePromotion['type'];
            $promotion->price = $singlePromotion['price'];
            $promotion->duration = $singlePromotion['duration'];
            $promotion->save();
        }
    }
}
