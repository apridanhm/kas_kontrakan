<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up(): void
{
Schema::create('transactions', function (Blueprint $table) {
$table->id();
$table->date('date');
$table->enum('type', ['income', 'expense']);
$table->string('category')->nullable();
$table->string('title');
$table->text('description')->nullable();
$table->unsignedInteger('amount');
$table->timestamps();


$table->index(['date', 'type']);
});
}


public function down(): void
{
Schema::dropIfExists('transactions');
}
};