<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Listing;
use App\Models\State;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketplaceTest extends TestCase
{
    use RefreshDatabase;

    private Country $country;

    private State $state;

    private City $city;

    private Area $area;

    private Category $category;

    private Subcategory $subcategory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->country = Country::create(['name' => 'India', 'slug' => 'india', 'iso_code' => 'IN']);
        $this->state = State::create(['country_id' => $this->country->id, 'name' => 'Maharashtra', 'slug' => 'maharashtra']);
        $this->city = City::create(['state_id' => $this->state->id, 'name' => 'Mumbai', 'slug' => 'mumbai']);
        $this->area = Area::create(['city_id' => $this->city->id, 'name' => 'Andheri', 'slug' => 'andheri']);
        $this->category = Category::create(['name' => 'Electronics', 'slug' => 'electronics', 'position' => 1]);
        $this->subcategory = Subcategory::create([
            'category_id' => $this->category->id,
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
        ]);
    }

    public function test_guest_can_view_home_and_listing_pages(): void
    {
        $listing = $this->makeListing();

        $this->get('/')->assertOk()->assertSee($listing->name);
        $this->get('/listings')->assertOk()->assertSee($listing->name);
        $this->get('/category/electronics')->assertOk()->assertSee($listing->name);
        $this->get('/city/mumbai')->assertOk()->assertSee($listing->name);
        $this->get('/city/mumbai/category/electronics')->assertOk()->assertSee($listing->name);
        $this->get('/listing/'.$listing->id)->assertOk()->assertSee($listing->detail);
    }

    public function test_guest_is_redirected_from_protected_pages(): void
    {
        $this->get('/post-ad')->assertRedirect('/login');
        $this->get('/my-listings')->assertRedirect('/login');
    }

    public function test_user_can_register_and_publish_a_listing(): void
    {
        $this->post('/register', [
            'name' => 'Test Seller',
            'email' => 'seller@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect('/dashboard');

        $this->post('/post-ad', [
            'type' => 'product',
            'name' => 'Brand New Wireless Earbuds',
            'detail' => 'Sealed wireless earbuds with 1 year warranty and type C charging.',
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'country_id' => $this->country->id,
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'area_id' => $this->area->id,
            'price' => 2999,
        ])->assertRedirect();

        $this->assertDatabaseHas('listings', ['name' => 'Brand New Wireless Earbuds']);

        $listing = Listing::firstWhere('name', 'Brand New Wireless Earbuds');

        $this->get('/listing/'.$listing->id)->assertOk()->assertSee('Brand New Wireless Earbuds');
        $this->get('/listings?q=Wireless')->assertOk()->assertSee('Brand New Wireless Earbuds');
        $this->get('/category/electronics')->assertOk()->assertSee('Brand New Wireless Earbuds');
        $this->get('/city/mumbai/category/electronics')->assertOk()->assertSee('Brand New Wireless Earbuds');
        $this->get('/my-listings')->assertOk()->assertSee('Brand New Wireless Earbuds');
    }

    public function test_listing_validation_requires_all_location_fields(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/post-ad', ['type' => 'product', 'name' => '', 'detail' => ''])
            ->assertSessionHasErrors(['name', 'detail', 'category_id', 'country_id', 'state_id', 'city_id', 'price']);

        $this->assertDatabaseCount('listings', 0);
    }

    public function test_owner_can_delete_their_listing(): void
    {
        $listing = $this->makeListing();

        $this->actingAs($listing->user)
            ->delete('/listings/'.$listing->id)
            ->assertRedirect('/my-listings');

        $this->assertDatabaseMissing('listings', ['id' => $listing->id]);
    }

    private function makeListing(): Listing
    {
        return Listing::create([
            'user_id' => User::factory()->create()->id,
            'type' => 'product',
            'name' => 'Used Nikon DSLR Camera',
            'detail' => 'Nikon D5600 with two lenses and camera bag, shutter count under 8000.',
            'category_id' => $this->category->id,
            'subcategory_id' => $this->subcategory->id,
            'country_id' => $this->country->id,
            'state_id' => $this->state->id,
            'city_id' => $this->city->id,
            'area_id' => $this->area->id,
            'price' => 42000,
            'is_active' => true,
        ]);
    }
}
