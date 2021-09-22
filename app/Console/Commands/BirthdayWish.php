<?php

namespace App\Console\Commands;

use App\Services\Birthday;
use Illuminate\Console\Command;

class BirthdayWish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:wish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Birthday wishes';

    /**
     * @var Birthday
     */
    protected $birthday;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Birthday $birthday)
    {
        parent::__construct();
        $this->birthday = $birthday;
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle()
    {
        return $this->birthday->sendBirthdayWish();
    }
}
