<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Report;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected function createUser()
    {
        return User::create([
            'name' => 'Komment Felhasználó',
            'email' => 'komment@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);
    }
    protected function createAdmin()
    {
        return User::create([
            'name' => 'Komment Admin',
            'email' => 'kommentadmin@example.com',
            'password' => bcrypt('password'),
            'role' => 0,
        ]);
    }

    protected function createReport()
    {
        return Report::create([
            'creator_id' => 1,
            'status' => 't',
            'address' => 'Komment utca 1.',
            'color' => 'fehér',
            'pattern' => 'foltos',
            'activity' => 1,
        ]);
    }

    public function test_store_comment()
    {
        $user = $this->createUser();
        $report = $this->createReport();

        $response = $this->actingAs($user)->post('/api/create-comment', [
            'report' => $report->report_id,
            'user' => $user->id,
            'content' => 'Ez egy teszt komment.',
        ]);

        $response->assertStatus(201);
    }

    public function test_store_comment_with_photo()
    {
        Storage::fake('public');
        $user = $this->createUser();
        $report = $this->createReport();

        $response = $this->actingAs($user)->post('/api/create-comment', [
            'report' => $report->report_id,
            'user' => $user->id,
            'content' => 'Komment fotóval',
           'photo' => UploadedFile::fake()->create('cica.jpg', 500, 'image/jpeg'),
        ]);

        $response->assertStatus(201);
    }


    public function test_get_comments_by_report()
    {
        $user = $this->createUser();
        $report = $this->createReport();
        Comment::create([
            'report' => $report->report_id,
            'user' => $user->id,
            'content' => 'Riporthoz tartozó komment',
        ]);

        $response = $this->actingAs($user)->get('/api/comments/by-report/' . $report->report_id);
        $response->assertStatus(200);
    }



    public function test_delete_comment()
    {
        $user = $this->createAdmin();
        $report = $this->createReport();
        Comment::create([
            'report' => $report->report_id,
            'user' => $user->id,
            'content' => 'Törlendő komment',
        ]);

        $response = $this->actingAs($user)->delete('/api/delete-comment/' . $report->report_id . '/' . $user->id);
        $response->assertStatus(200);
    }
}
