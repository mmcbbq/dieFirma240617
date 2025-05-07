<?php
include '../config.php';
require_once '../vendor/autoload.php';
spl_autoload_register(function ($className) {
    if(file_exists('../classes/' . $className . '.php')){
        include '../classes/' . $className . '.php';
    };
});

$faker = Faker\Factory::create();
$faker->seed(100);
for ($i = 0; $i < 50; $i++) {
    $_POST['vorname'] = $faker->firstName();
    $_POST['nachname']=$faker->lastName();
    $_POST['bday'] =$faker->date();
    User::createObject();
}

for ($j = 0; $j < 20; $j++) {
    $_POST['name'] = $faker->company();
    Department::createObject();
}

echo $faker->words(100,true);


