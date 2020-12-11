<?php

namespace Tests\Feature;

use App\Models\CustomerGroup;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Faker\Factory;

class CreateCustomerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        Sanctum::actingAs(
            Role::namespace( 'admin' )->users->first(),
            ['*']
        );

        $faker  =   Factory::create();

        $group  =   CustomerGroup::first();

        /**
         * Creating a first customer
         */
        $response       =   $this->withSession( $this->app[ 'session' ]->all() )
            ->json( 'POST', 'api/nexopos/v4/crud/ns.customers', [
                'name'  =>  $faker->firstName,
                'general'   =>  [
                    'group_id'  =>  $group->id,
                    'surname'   =>  $faker->lastName,
                    'email'     =>  $faker->email
                ]
            ]);

        $response->assertJson([
            'status'    =>  'success'
        ]);

        /**
         * creating a second customers
         */
        $response       =   $this->withSession( $this->app[ 'session' ]->all() )
            ->json( 'POST', 'api/nexopos/v4/crud/ns.customers', [
                'name'  =>  $faker->firstName,
                'general'   =>  [
                    'group_id'  =>  $group->id,
                    'surname'   =>  $faker->lastName,
                    'email'     =>  $faker->email
                ]
            ]);

        $response->assertJson([
            'status'    =>  'success'
        ]);
    }
}
