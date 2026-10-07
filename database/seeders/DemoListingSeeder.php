<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoListingSeeder extends Seeder
{
    private array $ads = [
        ['product', 'iPhone 13 Pro 256GB', 'Excellent condition iPhone 13 Pro, 256GB, Deep Green. Battery health 91%. Original box, charger and bill available. No scratches or dents.', 'Electronics', 'Mobile Phones'],
        ['product', 'Samsung Galaxy S23', 'Like new Samsung Galaxy S23 with 12 months of warranty left. Comes with original accessories and tempered glass applied.', 'Electronics', 'Mobile Phones'],
        ['product', 'MacBook Air M2 (8/256)', 'MacBook Air M2 13 inch, 8GB RAM, 256GB SSD. Purchased 8 months ago, still under warranty. Perfect for students and developers.', 'Electronics', 'Laptops'],
        ['product', 'Dell XPS 15 Laptop', 'Dell XPS 15 with i7 11th gen, 16GB RAM, 1TB SSD, GTX 1650. Great for video editing and gaming. Includes laptop bag.', 'Electronics', 'Laptops'],
        ['product', 'Sony WH-1000XM4 Headphones', 'Noise cancelling Sony headphones, barely used, box and cable included. Sounds superb and battery lasts 30 hours.', 'Electronics', 'Audio & Video'],
        ['product', 'Used Honda City VX 2019', 'Single owner Honda City 2019 model, petrol, automatic, 42,000 km. Full service history with authorised service centre. Insurance valid till March.', 'Vehicles', 'Cars'],
        ['product', 'Maruti Swift ZXi 2021', 'Maruti Swift ZXi+, 2021, 24,000 km, showroom maintained. New tyres, alloy wheels, reverse camera.', 'Vehicles', 'Cars'],
        ['product', 'Royal Enfield Classic 350', 'Classic 350 Halcyon Grey, 2022, 9,000 km. First owner, all documents clear, NOC available.', 'Vehicles', 'Motorcycles'],
        ['product', 'TVS Ntorq 125 Scooter', 'TVS Ntorq Race XP, 2023, 4,500 km. Under warranty, excellent mileage, well maintained.', 'Vehicles', 'Scooters'],
        ['service', '2 BHK Flat for Rent', 'Furnished 2 BHK flat available for rent near metro. Semi-furnished with modular kitchen, geyser and wardrobes. Family preferred.', 'Real Estate', 'Apartments'],
        ['product', 'Residential Plot in Sector 150', 'Corner plot 150 sq yards, approved by authority, ready for construction. Park facing, clear title.', 'Real Estate', 'Plots & Land'],
        ['product', '3 BHK Builder Floor for Sale', 'Spacious 3 BHK builder floor with lift and parking. East facing, 1650 sq ft, possession ready.', 'Real Estate', 'Houses'],
        ['product', 'L Shape Sofa Set', '5 seater L shape sofa in grey fabric, 2 years old, no tears or stains. Moving out hence selling.', 'Furniture', 'Sofa & Seating'],
        ['product', 'King Size Bed with Storage', 'Sheesham wood king size bed with box storage and two side tables. Polished and durable.', 'Furniture', 'Beds & Mattresses'],
        ['product', '4 Door Wardrobe', 'Teak finish 4 door wardrobe with mirror and drawers. Excellent condition, disassembly and transport by buyer.', 'Furniture', 'Wardrobes'],
        ['product', '6 Seater Dining Table', 'Solid wood 6 seater dining set with cushion chairs. Barely used, selling due to relocation.', 'Furniture', 'Dining'],
        ['product', 'Double Door Refrigerator', 'Samsung 253L double door fridge, 3 star, 4 years old. Works perfectly, cooling is excellent.', 'Home Appliances', 'Refrigerators'],
        ['product', 'Front Load Washing Machine', 'LG 7kg front load washing machine, 2 years old, all features working. With invoice.', 'Home Appliances', 'Washing Machines'],
        ['product', '1.5 Ton Split AC', 'Voltas 1.5 ton 5 star inverter AC, 3 years old. Serviced this season, cooling superb. Installation extra.', 'Home Appliances', 'Air Conditioners'],
        ['product', 'Microwave and OTG Combo', 'IFB microwave with convection plus oven toaster grill. Both in working condition, with accessories.', 'Home Appliances', 'Kitchen Appliances'],
        ['product', 'Men Formal Shirt Bundle', '5 formal shirts, size L, brands like Peter England and Van Heusen. All in mint condition.', 'Fashion', 'Men Clothing'],
        ['product', 'Designer Saree Collection', 'Pure georgette designer sarees with blouse piece, worn once for a wedding. Set of 3.', 'Fashion', 'Women Clothing'],
        ['product', 'Nike Running Shoes', 'Nike Air Zoom, size 9 UK, used for a month. Zero wear on sole, box available.', 'Fashion', 'Footwear'],
        ['product', 'Fossil Analog Watch', 'Fossil stainless steel analog watch with leather strap. Original bill and box available.', 'Fashion', 'Watches & Jewellery'],
        ['service', 'Hiring: Sales Executive', 'Opening for sales executives, min 1 year experience, attractive salary plus incentives. Walk in interviews 10am-5pm.', 'Jobs', 'Full Time'],
        ['service', 'Hiring: Web Developer (Remote)', 'Remote role for a PHP/Laravel developer, 2+ years experience. Full time with flexible hours.', 'Jobs', 'Work From Home'],
        ['service', 'Internship - Digital Marketing', '3 month paid internship for marketing students. Training provided on SEO, ads and social media.', 'Jobs', 'Internships'],
        ['service', 'Home Deep Cleaning Service', 'Complete 2BHK deep cleaning including kitchen, bathrooms and balconies. Trained staff, own equipment, eco friendly chemicals.', 'Services', 'Home Services'],
        ['service', 'AC Repair & Servicing', 'All brands AC repair, gas refill and installation at doorstep. Same day service, 30 day warranty on work.', 'Services', 'Repair & Maintenance'],
        ['service', 'Home Tuition - Maths & Science', '10 years experienced teacher offering Maths and Science tuition for class 6 to 10. Batches at home or online.', 'Services', 'Education & Tuition'],
        ['service', 'Birthday Party Decoration', 'Theme based birthday decoration at home with balloons, banners and props. Customised packages available.', 'Services', 'Events & Catering'],
        ['product', 'Labrador Puppy', 'Healthy and vaccinated Labrador puppies, 45 days old, dewormed. KCI papers available. Only genuine buyers.', 'Pets', 'Dogs'],
        ['product', 'Cat Tree and Scratching Post', 'Large cat tree with hammock and scratching post, 3 months old, very sturdy.', 'Pets', 'Pet Accessories'],
        ['product', 'Dog Walking Service', 'Daily dog walking and pet sitting service in your society. Trusted and insured pet lover.', 'Pets', 'Pet Services'],
        ['product', 'NEET Preparation Book Set', 'Complete NEET preparation books set of 11 books, 2024 edition. Marked notes included, good condition.', 'Books, Sports & Hobby', 'Books'],
        ['product', 'Yonex Badminton Racket', 'Yonex Nanoray racket with full cover, used for 2 months. Grip is fresh and light weight.', 'Books, Sports & Hobby', 'Sports Goods'],
        ['product', 'Yamaha Acoustic Guitar', 'Yamaha F310 acoustic guitar, perfect tuning, with strap and pick set. Ideal for beginners.', 'Books, Sports & Hobby', 'Musical Instruments'],
        ['product', 'Vinyl Record Collection', 'Collection of 15 classic vinyl records in original sleeves. All playable and well preserved.', 'Books, Sports & Hobby', 'Collectibles'],
        ['service', 'Bike Rental for Tourists', 'Well maintained bikes available on daily rental with helmets. Instant delivery in city area.', 'Services', 'Home Services'],
        ['product', 'Office Chairs (Set of 4)', 'Ergonomic mesh office chairs with adjustable height and lumbar support. Company shutting down, bulk sale.', 'Furniture', 'Sofa & Seating'],
    ];

    private array $prices = [
        'iPhone 13 Pro 256GB' => 62000,
        'Samsung Galaxy S23' => 45000,
        'MacBook Air M2 (8/256)' => 68000,
        'Dell XPS 15 Laptop' => 72000,
        'Sony WH-1000XM4 Headphones' => 18500,
        'Used Honda City VX 2019' => 845000,
        'Maruti Swift ZXi 2021' => 625000,
        'Royal Enfield Classic 350' => 148000,
        'TVS Ntorq 125 Scooter' => 79000,
        '2 BHK Flat for Rent' => 22000,
        'Residential Plot in Sector 150' => 4500000,
        '3 BHK Builder Floor for Sale' => 8750000,
        'L Shape Sofa Set' => 12500,
        'King Size Bed with Storage' => 18500,
        '4 Door Wardrobe' => 22000,
        '6 Seater Dining Table' => 26500,
        'Double Door Refrigerator' => 9500,
        'Front Load Washing Machine' => 14800,
        '1.5 Ton Split AC' => 24500,
        'Microwave and OTG Combo' => 6800,
        'Men Formal Shirt Bundle' => 2750,
        'Designer Saree Collection' => 6500,
        'Nike Running Shoes' => 3800,
        'Fossil Analog Watch' => 5400,
        'Hiring: Sales Executive' => 30000,
        'Hiring: Web Developer (Remote)' => 75000,
        'Internship - Digital Marketing' => 12000,
        'Home Deep Cleaning Service' => 2600,
        'AC Repair & Servicing' => 800,
        'Home Tuition - Maths & Science' => 3500,
        'Birthday Party Decoration' => 4500,
        'Labrador Puppy' => 15500,
        'Cat Tree and Scratching Post' => 3600,
        'Dog Walking Service' => 2500,
        'NEET Preparation Book Set' => 3400,
        'Yonex Badminton Racket' => 3200,
        'Yamaha Acoustic Guitar' => 7800,
        'Vinyl Record Collection' => 9500,
        'Bike Rental for Tourists' => 1200,
        'Office Chairs (Set of 4)' => 18000,
    ];

    public function run(): void
    {
        $users = User::factory()->count(6)->create();

        $categories = Category::with('subcategories')->get();

        foreach ($this->ads as $index => [$type, $name, $detail, $categoryName, $subcategoryName]) {
            $category = $categories->firstWhere('name', $categoryName);
            if (! $category) {
                continue;
            }

            $subcategory = $category->subcategories->firstWhere('name', $subcategoryName);

            $city = City::inRandomOrder()->first();
            $area = $city->areas()->inRandomOrder()->first();
            $state = $city->state;
            $country = $state->country;

            Listing::create([
                'user_id' => $users[$index % $users->count()]->id,
                'type' => $type,
                'name' => $name,
                'detail' => $detail,
                'category_id' => $category->id,
                'subcategory_id' => $subcategory?->id,
                'country_id' => $country->id,
                'state_id' => $state->id,
                'city_id' => $city->id,
                'area_id' => $area?->id,
                'price' => $this->prices[$name] ?? 0,
                'image' => null,
                'is_active' => true,
            ]);
        }
    }
}
