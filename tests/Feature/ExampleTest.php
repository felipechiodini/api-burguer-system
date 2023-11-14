<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserStore;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {

        // User::query()->create([
        //     'name' => 'dddddddddddddddddd',
        //     'email' => 'felipechiodinibona@hotmail.com',
        //     'cellphone' => '47999097073',
        //     'password' => Hash::make('132567'),
        //     'root' => true
        // ]);

        // dd(User::query()->get());
        // UserStore::query()->create([
        //     'name' => 'vais se fuder',
        //     'slug' => 'fodase'
        // ]);
        // dd(UserStore::query()->get());
        $response = $this->get('/delivery/bona/store');

        $response->assertStatus(200);
    }
}
