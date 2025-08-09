<?php

namespace Database\Seeders;

use Spatie\Tags\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::findOrCreate('non-alcoholic', 'itemTag');
        Tag::findOrCreate('beer & cider', 'itemTag');
        Tag::findOrCreate('wine', 'itemTag');
        Tag::findOrCreate('spirit', 'itemTag');
        Tag::findOrCreate('whisky', 'itemTag');
        Tag::findOrCreate('vodka', 'itemTag');
        Tag::findOrCreate('gin', 'itemTag');
        Tag::findOrCreate('brandy', 'itemTag');
        Tag::findOrCreate('tequila', 'itemTag');
        Tag::findOrCreate('cocktail', 'itemTag');
        Tag::findOrCreate('glassware', 'itemTag');
        Tag::findOrCreate('mixers', 'itemTag');
        Tag::findOrCreate('snacks', 'itemTag');
        Tag::findOrCreate('others', 'itemTag');

    }
}
