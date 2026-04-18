<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('m_user', function (Blueprint $table) {
            $table->dropForeign(['level_id']);           // ← drop FK dulu
            $table->integer('level_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('m_user', function (Blueprint $table) {
            $table->integer('level_id')->nullable(false)->change();
            $table->foreign('level_id')->references('level_id')->on('m_level');
        });
    }
};