<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->relaxOrderPaymentMethodConstraint();

        Schema::create('floosak_payment_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('request_id')->unique();
            $table->unsignedBigInteger('source_wallet_id');
            $table->string('target_phone', 32);
            $table->decimal('amount', 15, 2);
            $table->string('purpose');
            $table->string('gateway_purchase_id')->nullable()->index();
            $table->string('gateway_transaction_id')->nullable()->index();
            $table->string('gateway_reference_id')->nullable()->index();
            $table->string('gateway_status_en')->nullable();
            $table->string('gateway_status_ar')->nullable();
            $table->decimal('net', 15, 2)->nullable();
            $table->decimal('fee', 15, 2)->nullable();
            $table->decimal('gross', 15, 2)->nullable();
            $table->decimal('balance', 15, 2)->nullable();
            $table->string('status')->index();
            $table->json('send_request_payload')->nullable();
            $table->json('send_response_payload')->nullable();
            $table->json('confirm_response_payload')->nullable();
            $table->json('status_response_payload')->nullable();
            $table->string('last_error_code')->nullable();
            $table->text('last_error_message')->nullable();
            $table->json('last_error_payload')->nullable();
            $table->unsignedInteger('reconciliation_attempts')->default(0);
            $table->timestamp('last_reconciled_at')->nullable();
            $table->timestamp('next_reconcile_at')->nullable()->index();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();
        });

        $this->createActiveAttemptIndex();
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['pgsql', 'sqlite'], true)) {
            DB::statement('DROP INDEX IF EXISTS floosak_payment_attempts_order_active_unique');
        }

        Schema::dropIfExists('floosak_payment_attempts');
    }

    private function createActiveAttemptIndex(): void
    {
        $driver = DB::getDriverName();
        $activeStatuses = "'initiating', 'pending', 'send_unknown', 'confirming', 'confirm_unknown'";

        if (in_array($driver, ['pgsql', 'sqlite'], true)) {
            DB::statement(
                "CREATE UNIQUE INDEX floosak_payment_attempts_order_active_unique
                ON floosak_payment_attempts (order_id)
                WHERE status IN ({$activeStatuses})"
            );
        }
    }

    private function relaxOrderPaymentMethodConstraint(): void
    {
        if (!Schema::hasTable('orders') || !Schema::hasColumn('orders', 'payment_method')) {
            return;
        }

        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            $constraints = DB::select(<<<'SQL'
                SELECT conname
                FROM pg_constraint
                WHERE conrelid = 'orders'::regclass
                  AND contype = 'c'
                  AND pg_get_constraintdef(oid) LIKE '%payment_method%'
            SQL);

            foreach ($constraints as $constraint) {
                $name = str_replace('"', '""', $constraint->conname);
                DB::statement("ALTER TABLE orders DROP CONSTRAINT IF EXISTS \"{$name}\"");
            }

            return;
        }

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method VARCHAR(191) NOT NULL DEFAULT 'cash_on_delivery'");
        }
    }
};
