<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;


class QuestionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'APPLE','BANANA','CAR','COMPUTER','MOUNTAIN','BUFFALO','SKY','SEA','CHAIR','TIGER','GRAPES','DOOR','BIKE','SHOES','ELECTRIC','COUNTRY','INDONESIA','NEPAL','INDIA',
            'SENEGAL','KAMERUN','CHINA','RUSSIA','ITALIA','GERMANY','RONALDO','MESSI','JAKARTA','BANDUNG','TOKYO','REMOTE','WOOD','STONE','ICE','TURTLE','CROCODILE','IGUANA','GOOGLE','MICROSOFT','AMAZON','PINEAPPLE','BLACKPINK','TABLE','SCISSOR','KNIFE','UMBRELLA','FIRE','AMBULANCE','STATION','AIRPLANE','HELICOPTER','JETSKY','TITANIC'
        ];

        foreach($data as $word) :
            Question::create([
                'word' => $word
            ]);
        endforeach;
    }
}
