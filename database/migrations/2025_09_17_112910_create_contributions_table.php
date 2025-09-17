<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('income_category_id')->constrained()->cascadeOnDelete();
            $table->string('month_year', 7); // YYYY-MM
            $table->date('paid_at')->nullable();
            $table->unsignedInteger('amount');
            $table->timestamps();

            $table->unique(['member_id', 'income_category_id', 'month_year'], 'uniq_member_category_month');
            $table->index('month_year');
        });
    }
    public function down(): void {
        Schema::dropIfExists('contributions');
    }
};
