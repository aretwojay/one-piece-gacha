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
        Schema::dropIfExists('characters');
        if (!Schema::hasTable('characters')) {
            Schema::create('characters', function (Blueprint $table) {
                $table->id();
                $table->string('japanese_name')->nullable();
                $table->string('english_name')->nullable();
                $table->string('romaji_name')->nullable();
                $table->string('image_url')->nullable();
                $table->json('debut_appearance')->nullable();
                $table->json('affiliations')->nullable();
                $table->json('occupations')->nullable();
                $table->string('status')->nullable();
                $table->string('birthday')->nullable();
                $table->string('devil_fruit')->nullable();
                $table->string('bounty')->nullable();
                $table->string('age')->nullable();
                $table->string('origin')->nullable();
                $table->string('height')->nullable();
                $table->string('blood_type')->nullable();
                $table->unsignedInteger('hp')->nullable();
                $table->unsignedInteger('attack')->nullable();
                $table->unsignedInteger('defense')->nullable();
                $table->unsignedInteger('speed')->nullable();
                $table->string('rarity')->nullable();
                $table->timestamps();
            });
        }

        $str = file_get_contents(__DIR__ . "/../../scrapper/data_characters.json");
        $str = mb_convert_encoding($str, "UTF-8");
        $json = json_decode($str, true);

        foreach ($json as $value) {
          App\Models\Character::create($value);
        }

      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
