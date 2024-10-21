<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const DATABASE = 'contractor';
    private const CONTRACTOR_TABLE = 'contractor';
    private const TRANSACTION_TABLE = 'transaction';

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create(self::CONTRACTOR_TABLE, static function (Blueprint $table) {
                $table->uuid('id')->primary()->default(DB::raw('uuid_generate_v4()'));
                $table->string('first_name');
                $table->string('last_name');
                $table->string('middle_name')->nullable();
                $table->date('birth_date');
                $table->softDeletesTz();
                $table->timestampsTz();
            });

        Schema::create(self::TRANSACTION_TABLE, static function (Blueprint $table) {
                $table->uuid('id')->primary()->default(DB::raw('uuid_generate_v4()'));
                $table->float('amount')->nullable(false);
                $table->foreignUuid('contractor_id')
                    ->nullable(false)
                    ->constrained(self::CONTRACTOR_TABLE);
                $table->softDeletesTz();
                $table->timestampsTz();
            });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TRANSACTION_TABLE);
        Schema::dropIfExists(self::CONTRACTOR_TABLE);
    }
};
