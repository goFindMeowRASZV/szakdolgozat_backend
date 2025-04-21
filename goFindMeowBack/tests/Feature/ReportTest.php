<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;


class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_sheltered_reports_filter()
    {
        $user = User::where('email', 'admin@admin.hu')->first();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'csrf '
        ])->get('/api/get-sheltered-report-filter/voros,cirmos');

        $response->assertStatus(200);
    }
    public function test_get_reports_filter()
    {
        $user = User::where('email', 'admin@admin.hu')->first();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'csrf '
        ])->get('/api/get-report-filter/t,voros,cirmos');
        $response->assertStatus(200);
    }

    public function test_create_report()

    {
        $user = User::where('email', 'admin@admin.hu')->first();

        $response = $this->actingAs($user)->post('api/create-report', [
            'creator_id' => '3',
            'status' => 'K',
            'address' => 'Király u 96.',
            'color' => 'voros',
            'pattern' => 'cirmos',
            'other_identifying_marks' => 'gfvhgd',
            'health_status' => 'jo',
            'photo' => UploadedFile::fake()->create('cica.jpg', 500, 'image/jpeg'),
            'activity' => 1,
            'chip_number' => '123456789876543',
            'circumstances' => 'valami',
            'number_of_individuals' => '1',
            'disappearance_date' => '2024-02-01',

        ]);

        $response->assertStatus(201);
    }
    public function test_update_report()
{
    $user = User::where('email', 'admin@admin.hu')->first();

    // Manuálisan létrehozott report a kötelező mezőkkel
    $report = \App\Models\Report::create([
        'creator_id' => $user->id,
        'status' => 'k',
        'address' => 'Teszt utca 12.',
        'color' => 'feher',
        'pattern' => 'foltos',
        'activity' => 1
    ]);

    $response = $this->actingAs($user)->put('/api/update-reports/' . $report->report_id, [
        'status' => 't',
        'color' => 'szurke',
        'pattern' => 'cirmos',
        'number_of_individuals' => 2
    ]);

    $response->assertStatus(200);
}

    public function test_get_map_reports()
    {
        $user = User::where('email', 'admin@admin.hu')->first();

        $response = $this->actingAs($user)->get('/api/get-map-reports');

        $response->assertStatus(200);
    }

    public function test_search_reports()
    {
        $user = User::where('email', 'admin@admin.hu')->first();

        $response = $this->actingAs($user)->get('/api/reports-search?q=cirmos');

        $response->assertStatus(200);
    }
}
