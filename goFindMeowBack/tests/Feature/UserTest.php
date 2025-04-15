<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function createUser($role = 0)
    {
        return User::create([
            'name' => 'Teszt Admin',
            'email' => 'admin' . $role . '@example.com',
            'password' => Hash::make('password123'),
            'role' => $role
        ]);
    }

    public function test_index_users()
    {
        $admin = $this->createUser();
        $this->actingAs($admin);

        $response = $this->get('/api/get-users');
        $response->assertStatus(200);
    }

    public function test_create_user_by_admin()
    {
        $admin = $this->createUser();
        $this->actingAs($admin);

        $response = $this->post('/api/create-user', [
            'name' => 'Új Tesztelő',
            'email' => 'ujteszt@example.com',
            'password' => 'password123',
            'role' => 2
        ]);

        $response->assertStatus(201);
    }

    public function test_update_user_password()
    {
        $admin = $this->createUser();
        $this->actingAs($admin);

        $response = $this->put('/api/admin/update-user/' . $admin->id, [
            'name' => 'Frissített Név'
        ]);

        $response->assertStatus(200);
    }

    public function test_change_own_password()
    {
        $user = $this->createUser(2);
        $this->actingAs($user);

        $response = $this->put('/api/change-password', [
            'current_password' => 'password123',
            'new_password' => 'ujjelszo123',
            'new_password_confirmation' => 'ujjelszo123'
        ]);

        $response->assertStatus(200);
    }

    public function test_upload_profile_picture()
    {
        Storage::fake('public');
        $user = $this->createUser();
        $this->actingAs($user);

   

        $response = $this->post('/api/profile-picture', [
            'profile_picture' => UploadedFile::fake()->create('cica.jpg', 500, 'image/jpeg'),
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_user()
    {
        $admin = $this->createUser();
        $user = User::create([
            'name' => 'Törlendő',
            'email' => 'torlendo@example.com',
            'password' => Hash::make('password'),
            'role' => 2
        ]);

        $this->actingAs($admin);

        $response = $this->delete('/api/admin/delete-user/' . $user->id);

        $response->assertStatus(200);
    }
}
