<?php

namespace Tests\Feature;


use App\Models\User;
use Cata\Prohibition\Facades\Prohibition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProhibitionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function normal_users_can_access_the_site()
    {
        /**
         * @var User $user
         */
        $user = User::factory()->create()->first();


        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function banned_users_cannot_access_the_site()
    {
        /**
         * @var User $user
         */
        $user = User::factory()->create()->first();

        $user->ban();

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(403);
    }

    /** @test */
    public function users_can_be_unbanned()
    {
        /**
         * @var User $user
         */
        $user = User::factory()->create()->first();

        $user->ban();

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(403);

        $user->unban();

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function users_can_be_banned_as_using_id_in_facade()
    {
        /**
         * @var User $user
         */
        $user = User::factory()->create()->first();

        Prohibition::banModel($user->id, now()->addMinute());

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(403);
    }

    /** @test */
    public function users_can_be_unbanned_using_id()
    {
        /**
         * @var User $user
         */
        $user = User::factory()->create()->first();

        Prohibition::banModel($user->id, now()->addMinute());


        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(403);


        Prohibition::unbanModel($user->id);


        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);
    }


    /** @test */
    public function users_can_be_unbanned_as_collection_using_facade()
    {
        /**
         * @var User $user
         */
        $users = User::factory(5)->create();

        Prohibition::banModel($users, now()->addMinute());

        foreach ($users as $user) {
            $this->actingAs($user);

            $response = $this->get('/');

            $response->assertStatus(403);
        }

        Prohibition::unbanModel($users);

        foreach ($users as $user) {
            $this->actingAs($user);

            $response = $this->get('/');

            $response->assertStatus(200);
        }
    }

    /** @test */
    public function users_can_be_banned_for_a_time()
    {
        /**
         * @var User $user
         */
        $user = User::factory()->create()->first();

        $user->banForMinutes(1);

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(403);
    }

    /** @test */
    public function users_can_be_banned_as_collection_using_facade()
    {
        /**
         * @var User $user
         */
        $users = User::factory(5)->create();

        Prohibition::banModel($users, now()->addMinute());

        foreach ($users as $user) {
            $this->actingAs($user);

            $response = $this->get('/');

            $response->assertStatus(403);
        }
    }

    /** @test */
    public function can_check_if_a_user_is_banned()
    {
        /**
         * @var User $user
         */
        $user = User::factory()->create()->first();

        $user->ban();

        $this->assertTrue($user->banned());

        $user->unban();

        $this->assertFalse($user->banned());
    }

    /** @test */
    public function can_check_if_a_collection_of_users_are_banned()
    {
        /**
         * @var User $user
         */
        $users = User::factory(5)->create();

        Prohibition::banModel($users, now()->addMinute());

        foreach ($users as $user) {
            $this->assertTrue($user->banned());
        }

        Prohibition::unbanModel($users);

        foreach ($users as $user) {
            $this->assertFalse($user->banned());
        }
    }

    /** @test */
    public function ip_can_be_banned_using_request_instance()
    {
        request()->ban();

        $this->get("/")->assertForbidden();

        $this->assertTrue(
            request()->banned()
        );
    }

    /** @test */
    public function ip_can_be_banned_for_specific_priod_using_request_instance()
    {
        request()->banForMinutes();

        $this->get("/")->assertForbidden();

        $this->assertTrue(
            request()->banned()
        );
    }


    /** @test */
    public function ip_can_be_banned_as_string_using_facade()
    {
        $ip = "156.45.1.0";

        $return = Prohibition::banIP($ip, now()->addMinute());

        $this->assertTrue($return);
    }

    /** @test */
    public function ip_can_be_banned_as_array_using_facade()
    {
        $ip = ["156.45.1.0", "156.45.1.0", "156.45.1.0", "156.45.1.0"];

        $return = Prohibition::banIP($ip, now()->addMinute());

        $this->assertTrue($return);
    }

    /** @test */
    public function ip_can_be_unbanned_as_string_using_facade()
    {
        $ip = "156.45.1.0";

        $this->assertTrue(
            Prohibition::banIP($ip, now()->addMinute())
        );

        $this->assertTrue(
            Prohibition::unbanIP($ip, now()->addMinute())
        );
    }

    /** @test */
    public function ip_can_be_unbanned_as_array_using_facade()
    {
        $ip = [
            "156.45.1.0", "156.45.1.0", "156.45.1.0", "156.45.1.0"
        ];

        $this->assertTrue(
            Prohibition::banIP($ip, now()->addMinute())
        );

        $this->assertTrue(
            Prohibition::unbanIP($ip, now()->addMinute())
        );
    }
}
