<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use App\Models\User_cv;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $user_cvs = ["1631975806_Nemanja Glogovac- CV.docx","1631975950_Nemanja Glogovac- CV.pdf","1631975950_Nemanja_Glogovac_cv_sr.pdf"];

        foreach (Range(1,30) as $key => $value) {
            $user = new User();
            $user->first_name = $faker->firstName();
            $user->last_name = $faker->lastName();
            $user->email = $faker->email();
            $user->password = md5("asdaasda");
            $user->phone = $faker->phoneNumber();
            $user->github = $faker->url();
            $user->linkedin = $faker->url();
            $user->image()->src = $faker->imageUrl(500,500);
            $user->image()->url = $faker->word(1);
            $user->portfolio_link = $faker->url();
            $user->about_me = $faker->sentence(5);
            $user->verified = time();
            $user->verification_number = Rand(10000,1000000);
            $user->role_id = Rand(1,3);
            $user->save();
            $userImage = new Image();
            $userImage->alt = $faker->word(1);
            $userImage->src = $faker->imageUrl(500,500);
            $userImage->imageable_id = $user->id;
            $userImage->imageable_type = "App\Models\User";
            $userImage->save();

            $userCV = new User_cv();
            $fileName = $user_cvs[array_rand($user_cvs)];
            $userCV->name = $fileName;
            $userCV->src = "user_cv-s/".$fileName;
            $userCV->main = 1;
            $userCV->user_id = $user->id;
            $userCV->save();
        }
    }
}
