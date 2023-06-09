<?php

namespace App\Console\Commands;

use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OTPExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleting expired OTP';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oneHourAgo = Carbon::now()->subHour();
        PasswordReset::where('created_at', '<=', $oneHourAgo)->delete();
        $this->info('Expired OTPs deleted successfully.');
    }
}
