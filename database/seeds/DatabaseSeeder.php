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

        factory(App\Tag::class, 10)->create();

        factory(App\User::class, 10)->create()
            ->each(function ($u) {
                $u->possessions()->saveMany(factory(App\Possession::class, 3)->make())
                ->each(function($p){

                    $tags = DB::table('tags')->get();
                    $tagsIds = $tags->pluck('id');
                    $r = collect([1, 2, 3, 4, 5]);
                    $p->tags()->attach($tagsIds->random($r->random()));

                    $users = DB::table('users')->get();
                    $usersIds = $users->pluck('id');
                    $r2 = collect([1, 2, 3, 4, 5, 6, 7]);
                    $p->share()->attach($usersIds->random($r2->random()));

                });
            });
    }
}
