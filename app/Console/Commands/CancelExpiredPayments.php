<?php

namespace App\Console\Commands;

use App\Services\PaymentService;
use Illuminate\Console\Command;

class CancelExpiredPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel program assignments with expired payment deadlines';

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
        $this->info('Cancelling expired payment assignments...');

        $cancelledCount = $this->paymentService->cancelExpiredPayments();

        $this->info("Expired assignments cancelled: {$cancelledCount}");

        return 0;
    }
}
