<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('titre')->nullable();
            $table->string('origine');
            $table->json('capacites'); // C'est ici qu'on stockera Fruits et Haki
            $table->text('avancement');
            $table->bigInteger('prime')->default(0);
            $table->string('image_url')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
