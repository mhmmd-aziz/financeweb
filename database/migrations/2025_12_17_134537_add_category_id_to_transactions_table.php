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
    Schema::table('transactions', function (Blueprint $table) {
        // Hapus kolom lama (string)
        $table->dropColumn('category'); 
        
        // Tambah kolom baru (relasi), boleh null dulu biar ga error data lama
        $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropForeign(['category_id']);
        $table->dropColumn('category_id');
        $table->string('category')->nullable();
    });
}
};
