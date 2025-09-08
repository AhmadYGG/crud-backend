<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // primary key, auto increment
            $table->string('name'); // string, required
            $table->text('description')->nullable(); // text, null/kosong
            $table->decimal('price', 10, 2); // required, 10 digit total, 2 digit desimal
            $table->integer('stock'); // integer, required
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            // foreign key ke users.id, otomatis cascade delete

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
