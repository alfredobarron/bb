<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        factory(App\User::class, 3)->create()
            ->each(function ($u) {
                $u->possessions()->saveMany(factory(App\Possession::class, 3)->make())
                ->each(function($p){
                    $p->tags()->attach(factory(App\Tag::class)->create());
                });
            });
    }
}
