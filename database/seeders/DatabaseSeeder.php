<?php

namespace Database\Seeders;

use App\Models\Number;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        collect([
            'Priscilla' => [8, 28],
            'Tifhany' => [16],
            'Ygor' => [13],
            'Mariana' => [29],
            'Paulinha' => [34],
            'Cesar' => [7],
            'Lilian SC' => [20],
            'Silvani Gta' => [43],
            'Amanda' => [21],
            'Moriele' => [9, 14],
            'Maridiane' => [40],
            'Paula/Daniel' => [10],
            'Marlete' => [1, 2],
            'Rúbia' => [18],
            'Adriane RS' => [47],
            'Vitória' => [05],
            'Binha' => [19],
            'Edilene' => [17],
            'Andréa' => [3, 75],
            'Jéssica RR' => [24],
            'Emilene' => [11],
            'Débora' => [12, 51],
        ])->map(fn(array $numbers, string $name) => Number::whereIn('value', $numbers)->update(['name' => $name]));


    }
}
