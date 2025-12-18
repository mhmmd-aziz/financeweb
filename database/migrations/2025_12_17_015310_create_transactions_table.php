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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('name'); // Nama transaksi (misal: Gaji, Beli Makan)
        $table->enum('type', ['income', 'expense']);
        $table->decimal('amount', 15, 2);
        $table->string('category')->nullable(); // Bisa dibuat tabel terpisah, tapi string dulu biar cepat
        $table->date('date');
        $table->string('image')->nullable(); // Bukti struk (opsional)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
