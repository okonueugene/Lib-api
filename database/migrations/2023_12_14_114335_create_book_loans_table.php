<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->date('can_date');
            $table->date('due_date');
            $table->date('return_date')
                ->nullable();
            $table->string('extended', 3)
                ->default('no');
            $table->string('extension_tale_cate', 200)
                ->nullable();
            $table->string('penalty_amount')
                ->nullable();
            $table->string('penalty_status', 15)->default('unpaid');
            $table->foreignId('added_by')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('updated_by')
                ->constrained('users')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_loans');
    }
};
