<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    private array $categories = [
        'Electronics' => ['Mobile Phones', 'Laptops', 'Accessories', 'Audio & Video'],
        'Vehicles' => ['Cars', 'Motorcycles', 'Scooters', 'Commercial Vehicles'],
        'Real Estate' => ['Apartments', 'Houses', 'Plots & Land', 'Commercial Space'],
        'Furniture' => ['Sofa & Seating', 'Beds & Mattresses', 'Wardrobes', 'Dining'],
        'Home Appliances' => ['Refrigerators', 'Washing Machines', 'Air Conditioners', 'Kitchen Appliances'],
        'Fashion' => ['Men Clothing', 'Women Clothing', 'Footwear', 'Watches & Jewellery'],
        'Jobs' => ['Full Time', 'Part Time', 'Internships', 'Work From Home'],
        'Services' => ['Home Services', 'Education & Tuition', 'Repair & Maintenance', 'Events & Catering'],
        'Pets' => ['Dogs', 'Cats', 'Pet Accessories', 'Pet Services'],
        'Books, Sports & Hobby' => ['Books', 'Sports Goods', 'Musical Instruments', 'Collectibles'],
    ];

    public function run(): void
    {
        foreach ($this->categories as $name => $subcategories) {
            $category = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'icon' => null,
                'position' => Category::count() + 1,
            ]);

            foreach ($subcategories as $sub) {
                Subcategory::create([
                    'category_id' => $category->id,
                    'name' => $sub,
                    'slug' => Str::slug($sub),
                ]);
            }
        }
    }
}
