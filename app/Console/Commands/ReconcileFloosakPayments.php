<?php

namespace App\Console\Commands;

use App\Models\FloosakPaymentAttempt;
use App\Services\Floosak\FloosakPaymentService;
use Illuminate\Console\Command;

class ReconcileFloosakPayments extends Command
{
    protected $signature = 'floosak:reconcile-payments {--limit=}';

    protected $description = 'Resolve Floosak payment attempts left in an indeterminate state.';

    public function handle(FloosakPaymentService $payments): int
    {
        $limit = (int) ($this->option('limit') ?: config('floosak.reconciliation.limit', 100));
        $maxAttempts = (int) config('floosak.reconciliation.max_attempts', 12);

        $attempts = FloosakPaymentAttempt::query()
            ->whereIn('status', [
                FloosakPaymentAttempt::STATUS_PENDING,
                FloosakPaymentAttempt::STATUS_SEND_UNKNOWN,
                FloosakPaymentAttempt::STATUS_CONFIRM_UNKNOWN,
            ])
            ->where('reconciliation_attempts', '<', $maxAttempts)
            ->where(function ($query) {
                $query->whereNull('next_reconcile_at')
                    ->orWhere('next_reconcile_at', '<=', now());
            })
            ->oldest('id')
            ->limit($limit)
            ->get();

        foreach ($attempts as $attempt) {
            $payments->reconcile($attempt);
        }

        $this->info("Reconciled {$attempts->count()} Floosak payment attempt(s).");

        return self::SUCCESS;
    }
}
