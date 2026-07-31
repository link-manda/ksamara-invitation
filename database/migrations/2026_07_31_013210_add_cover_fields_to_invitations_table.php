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
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('cover_image_path')->nullable()->after('bride_parents');
            $table->string('cover_bg_color')->nullable()->after('cover_image_path');
            $table->string('cover_recipient')->nullable()->after('cover_bg_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['cover_image_path', 'cover_bg_color', 'cover_recipient']);
        });
    }
};
