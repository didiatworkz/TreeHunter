<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tree_markers', function (Blueprint $table) {
            $table->string('category', 20)->default('mark')->after('client_uuid');
            $table->index(['user_id', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tree_markers', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'category']);
            $table->dropColumn('category');
        });
    }
};
