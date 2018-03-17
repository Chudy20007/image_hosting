<?php
use App\User;
use App\Comment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $j=1;
        for ($i = 1; $i < 5; $i++)
        {
            $user =User::find($i);

            $j=$i+5;
        $com = new Comment();
        $com->user_id =($user->id)+2;
        $com->picture_id = $i; 
        $com->is_active = 1;
        $com->comment = $faker->text(200);
        $com->save();

        $com2 = new Comment();
        $com2->user_id = ($user->id)+1;
        $com2->picture_id = $i;
        $com2->is_active = 0;
        $com2->comment = $faker->text(200);
        $com2->save();
        }
    }
}
