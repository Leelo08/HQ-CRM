<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

$factory->define(Company::class, function (Faker $faker) {

    $image = $faker->image();
    $imageFile = new File($image);

    return [
        'name' => $faker->company,
        'email' => $faker->unique()->safeEmail,
        'image' => Storage::disk('public')->putFile('uploads', $imageFile),
        'website' => $faker->safeEmailDomain,
    ];
});
