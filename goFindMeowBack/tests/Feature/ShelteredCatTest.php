<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Report;
use App\Models\ShelteredCat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ShelteredCatTest extends TestCase
{
    use RefreshDatabase;

    protected function createUser()
    {
        return User::create([
            'name' => 'Test Saff',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);
    }

    protected function createReport($creatorId)
    {
        return Report::create([
            'creator_id' => $creatorId,
            'status' => 't',
            'address' => 'Teszt utca 1.',
            'lat' => 47.5,
            'lon' => 19.04,
            'color' => 'fekete',
            'pattern' => 'cirmos',
            'activity' => 1,
            'number_of_individuals' => 1,
            'disappearance_date' => '2024-01-01'
        ]);
    }
    public function test_store_sheltered_cat()
    {
        $user = $this->createUser();
        $report = $this->createReport($user->id);

        $response = $this->actingAs($user)->post('/api/staff/create-sheltered-cat', [
            'rescuer' => $user->id,
            'report' => $report->report_id,
        ]);

        $response->assertStatus(201);
    }


    /* public function test_update_sheltered_cat()
    {
        $user = $this->createUser();
        $report = $this->createReport($user->id);

        $this->assertNotNull($user);
        $this->assertNotNull($report);

        $cat = ShelteredCat::create([
            'rescuer' => $user->id,
            'report' => $report->report_id,
        ]);

        $this->assertNotNull($cat);
        $this->assertDatabaseHas('sheltered_cats', [
            'report' => $report->report_id,
        ]);

        $response = $this->actingAs($user)->put('/api/update-sheltered-cat/' . $cat->id, [
            'kennel_number' => 12,
            'medical_record' => 'Egészséges'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('sheltered_cats', [
           'report' => $report->report_id,
            'kennel_number' => 12,
            'medical_record' => 'Egészséges'
        ]);
    }
    public function test_update_sheltered_cat_with_photo()
    {
        Storage::fake('public');
        $user = $this->createUser();
        $report = $this->createReport($user->id);

        $this->assertNotNull($user);
        $this->assertNotNull($report);

        $cat = ShelteredCat::create([
            'rescuer' => $user->id,
            'report' => $report->report_id,
        ]);

        $this->assertNotNull($cat);


        $response = $this->actingAs($user)->put('/api/update-sheltered-cat/' . $cat->id, [
            'photo' => UploadedFile::fake()->create('cica.jpg', 500, 'image/jpeg'),
            'kennel_number' => 5,
        ]);

        $response->assertStatus(200);

        // Ellenőrzés hogy a fájl valóban feltöltődött
        Storage::disk('public')->assertExists('sheltered/' . $photo->hashName());

        // Ellenőrzés hogy adatbázisban is frissült
        $this->assertDatabaseHas('sheltered_cats', [
            'report' => $report->report_id,
            'kennel_number' => 5,
        ]);
    } */
}
