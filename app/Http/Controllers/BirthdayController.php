<?php

namespace App\Http\Controllers;

use App\Services\Birthday;

class BirthdayController
{
    /**
     * @var Birthday
     */
    protected $birthday;

    public function __construct(Birthday $birthday)
    {
        $this->birthday = $birthday;
    }
    public function sendBirthdayWish()
    {
        return $this->birthday->sendBirthdayWish();
    }
}
