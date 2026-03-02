<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
        });

        // Isi username dari nama yang sudah ada (slug-ified, lowercase, spasi → _)
        DB::table('users')->get()->each(function ($user) {
            $base = strtolower(preg_replace('/\s+/', '_', $user->name));
            $base = preg_replace('/[^a-z0-9_]/', '', $base);
            $username = $base ?: 'user' . $user->id;

            // Pastikan unik
            $candidate = $username;
            $i = 1;
            while (DB::table('users')->where('username', $candidate)->where('id', '!=', $user->id)->exists()) {
                $candidate = $username . '_' . $i++;
            }

            DB::table('users')->where('id', $user->id)->update(['username' => $candidate]);
        });

        // Set NOT NULL setelah diisi
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn('username');
        });
    }
};
