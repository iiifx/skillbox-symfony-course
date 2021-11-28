<?php

declare(strict_types=1);

namespace App\Homework;

class RegistrationSpamFilter
{
    protected array $allow = ['.ru', '.com', '.org'];

    public function filter(string $email): bool
    {
        foreach ($this->allow as $zone) {
            if (str_ends_with($email, $zone)) {
                return false;
            }
        }

        return true;
    }
}
