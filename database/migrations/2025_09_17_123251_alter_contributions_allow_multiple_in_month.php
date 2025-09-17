<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1) Tambah index pengganti untuk FK
        Schema::table('contributions', function (Blueprint $table) {
            $table->index('member_id', 'contrib_member_idx');
            $table->index('income_category_id', 'contrib_category_idx');
        });

        // 2) Drop FK lama (nama default Laravel)
        DB::statement('ALTER TABLE contributions DROP FOREIGN KEY contributions_member_id_foreign');
        DB::statement('ALTER TABLE contributions DROP FOREIGN KEY contributions_income_category_id_foreign');

        // 3) Drop UNIQUE lama
        DB::statement('ALTER TABLE contributions DROP INDEX uniq_member_category_month');

        // 4) Ganti dengan index biasa + re-add FK
        Schema::table('contributions', function (Blueprint $table) {
            $table->index(['member_id','income_category_id','month_year'], 'idx_member_category_month');

            $table->foreign('member_id')
                ->references('id')->on('members')
                ->cascadeOnDelete();

            $table->foreign('income_category_id')
                ->references('id')->on('income_categories')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        // rollback: drop index baru, drop FK baru, balikin UNIQUE + FK awal
        Schema::table('contributions', function (Blueprint $table) {
            $table->dropIndex('idx_member_category_month');
            $table->dropIndex('contrib_member_idx');
            $table->dropIndex('contrib_category_idx');
        });

        DB::statement('ALTER TABLE contributions DROP FOREIGN KEY contributions_member_id_foreign');
        DB::statement('ALTER TABLE contributions DROP FOREIGN KEY contributions_income_category_id_foreign');

        DB::statement('ALTER TABLE contributions ADD UNIQUE INDEX uniq_member_category_month (member_id, income_category_id, month_year)');

        Schema::table('contributions', function (Blueprint $table) {
            $table->foreign('member_id')
                ->references('id')->on('members')
                ->cascadeOnDelete();
            $table->foreign('income_category_id')
                ->references('id')->on('income_categories')
                ->cascadeOnDelete();
        });
    }
};
