<?php

namespace App\Services;

use App\Models\Message;
use Faker\Factory;

class MailGenerator
{

    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function generateMessage()
    {
        return new Message(
            $this->generateEmail(),
            $this->generateBody()
        );
    }

    private function generateEmail()
    {
        return $this->faker->email;
    }

    private function generateBody()
    {
        return $this->faker->text;
    }
}
