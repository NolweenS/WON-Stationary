<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //We maken een nieuwe migration voor profile messages zodat de ontvanger terug kan antwoorden op het gestuurde bericht
    public function up(): void
    {
        Schema::table('profile_messages', function (Blueprint $table) {
            $table->foreignId('parent_id')
                ->nullable()
                ->after('message')
                ->constrained('profile_messages')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_messages', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
