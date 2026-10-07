<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    private array $data = [
        'India' => [
            'iso' => 'IN',
            'states' => [
                'Maharashtra' => [
                    'Mumbai' => ['Andheri', 'Bandra', 'Dadar', 'Thane'],
                    'Pune' => ['Kothrud', 'Hinjewadi', 'Baner', 'Shivajinagar'],
                    'Nagpur' => ['Dharampeth', 'Sadar', 'Itwari'],
                ],
                'Karnataka' => [
                    'Bangalore' => ['Koramangala', 'Indiranagar', 'Whitefield', 'JP Nagar'],
                    'Mysore' => ['Vijayanagar', 'Kuvempunagar', 'Gokulam'],
                    'Mangalore' => ['Bejai', 'Hampankatta', 'Kadri'],
                ],
                'Delhi' => [
                    'New Delhi' => ['Connaught Place', 'Saket', 'Dwarka', 'Rohini'],
                    'North Delhi' => ['Model Town', 'Pitampura', 'Shalimar Bagh'],
                ],
                'Tamil Nadu' => [
                    'Chennai' => ['T. Nagar', 'Adyar', 'Velachery', 'Anna Nagar'],
                    'Coimbatore' => ['RS Puram', 'Peelamedu', 'Singanallur'],
                ],
                'Uttar Pradesh' => [
                    'Lucknow' => ['Gomti Nagar', 'Hazratganj', 'Aliganj'],
                    'Noida' => ['Sector 18', 'Sector 62', 'Greater Noida West'],
                    'Kanpur' => ['Swaroop Nagar', 'Kidwai Nagar', 'Barra'],
                ],
                'Gujarat' => [
                    'Ahmedabad' => ['Satellite', 'Vastrapur', 'Bopal', 'Maninagar'],
                    'Surat' => ['Vesu', 'Adajan', 'Nanpura'],
                ],
                'Rajasthan' => [
                    'Jaipur' => ['Malviya Nagar', 'Vaishali Nagar', 'C-Scheme'],
                    'Jodhpur' => ['Ratanada', 'Sardarpura', 'Shastri Nagar'],
                ],
                'West Bengal' => [
                    'Kolkata' => ['Salt Lake', 'Behala', 'New Town', 'Gariahat'],
                    'Howrah' => ['Shibpur', 'Bally', 'Belur'],
                ],
            ],
        ],
        'United Arab Emirates' => [
            'iso' => 'AE',
            'states' => [
                'Dubai' => [
                    'Dubai' => ['Deira', 'Jumeirah', 'Marina', 'Bur Dubai'],
                ],
                'Abu Dhabi' => [
                    'Abu Dhabi' => ['Al Khalidiyah', 'Corniche', 'Mussafah'],
                ],
                'Sharjah' => [
                    'Sharjah' => ['Al Nahda', 'Al Majaz', 'University City'],
                ],
            ],
        ],
    ];

    public function run(): void
    {
        foreach ($this->data as $countryName => $countryData) {
            $country = Country::create([
                'name' => $countryName,
                'slug' => Str::slug($countryName),
                'iso_code' => $countryData['iso'],
            ]);

            foreach ($countryData['states'] as $stateName => $cities) {
                $state = State::create([
                    'country_id' => $country->id,
                    'name' => $stateName,
                    'slug' => Str::slug($stateName),
                ]);

                foreach ($cities as $cityName => $areas) {
                    $city = City::create([
                        'state_id' => $state->id,
                        'name' => $cityName,
                        'slug' => Str::slug($cityName),
                    ]);

                    foreach ($areas as $areaName) {
                        Area::create([
                            'city_id' => $city->id,
                            'name' => $areaName,
                            'slug' => Str::slug($areaName),
                        ]);
                    }
                }
            }
        }
    }
}
