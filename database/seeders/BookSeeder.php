<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Pengarang;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categories = Kategori::factory()->count(5)->create();
        $authors = Pengarang::factory()->count(10)->create();

        foreach (range(1, 250) as $index) {
            Buku::create([
                'judul' => $faker->sentence(3),
                'kategori_id' => $categories->random()->id,
                'pengarang_id' => $authors->random()->id,
                'tahun' => $faker->year,
            ]);
        }
    }
}
