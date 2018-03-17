<?php
use App\Picture;
use App\User;
use Illuminate\Database\Seeder;

class PicturesTableSeeder extends Seeder
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
        $x=1;
        for ($i = 1; $i < 5; $i++)
        {
            $user =User::find($i);

            $j=$i+5;
        $picture = new Picture();
        $picture ->title = $faker->company;
        $picture->user_id =$user->id;
        $picture->source = 'css\img\\'.$i.'\\'.$x.'.jpg';
        $picture->is_active = 1;
        $picture->visibility = 'public';

        $picture->description = $faker->text(200);
        $picture->save();
        $x++;

        $picture2 = new Picture();
        $picture2 ->title = $faker->company;
        $picture2->user_id =$user->id;
        $picture2->source = 'css\img\\'.$i.'\\'.$x.'.jpg';
        $picture2->is_active = 1;
        $picture2->visibility = 'public';
        $picture2->description = $faker->text(200);
        $picture2->save();
        $x++;
        }
    }
}
