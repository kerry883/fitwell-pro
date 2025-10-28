<?php

namespace App\Console\Commands;

use App\Services\PaymentService;
use Illuminate\Console\Command;

class SendPaymentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send payment reminders to clients with approaching payment deadlines';

    protected $paymentService;

    /**
     * Create a new command instance.
     */
    public function __construct(PaymentService $paymentService)
    {
        parent::__construct();
        $this->paymentService = $paymentService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sending payment reminders...');

        $remindersSent = $this->paymentService->sendPaymentReminders();

        $this->info("Payment reminders sent: {$remindersSent}");

        return 0;
    }
}
