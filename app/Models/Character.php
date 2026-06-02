<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\AsUri;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['japanese_name', 'english_name', 'romaji_name', 'image_url', 'debut_appearance', 'affiliations', 'origin', 'occupations', 'status', 'birthday', 'devil_fruit', 'bounty', 'age', 'height', 'blood_type', 'hp', 'attack', 'defense', 'speed', 'rarity'])]
class Character extends Model
{
    protected $casts = [
        'image_url' => AsUri::class,
        'debut_appearance' => 'json',
        'affiliations' => 'json',
        'occupations' => 'json',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'japanese_name' => '',
        'english_name' => '',
        'romaji_name' => '',
        'image_url' => null,
        'debut_appearance' => '[]',
        'affiliations' => '[]',
        'occupations' => '[]',
        'status' => '',
        'birthday' => null,
        'devil_fruit' => null,
        'bounty' => null,
        'age' => null,
        'height' => null,
        'blood_type' => null,
        'origin' => null,
    ];

    protected static function booted(): void
    {
        static::creating(function (Character $character) {
            $bounty = intval(preg_replace('/[^0-9]/', '', strtolower(str_replace(',', '', $character->bounty)))) ?? 0;

            if ($character->bounty === 'Unknown') {
                $character->rarity = 'Legendary';
            }

            if (count_chars($character->bounty, 1)['★'] ?? 0 > 4) {

                $character->rarity = 'Legendary';
            } elseif (count_chars($character->bounty, 1)['★'] ?? 0 > 2) {
                $character->rarity = 'Epic';
            } elseif (count_chars($character->bounty, 1)['★'] ?? 0 > 0) {
                echo $character->bounty.PHP_EOL;
                $character->rarity = 'Rare';
            }

            if (is_null($character->rarity)) {
                $character->rarity = $bounty > 1000000000 ? 'Legendary' : ($bounty > 100000000 ? 'Epic' : 'Rare');
            }
            if (is_null($character->hp)) {
                $character->hp = $character->rarity === 'Legendary' ? fake()->numberBetween(10000, 50000) : ($character->rarity === 'Epic' ? fake()->numberBetween(5000, 10000) : fake()->numberBetween(1000, 5000));
            }
            if (is_null($character->attack)) {
                $character->attack = $character->rarity === 'Legendary' ? fake()->numberBetween(10000, 50000) : ($character->rarity === 'Epic' ? fake()->numberBetween(5000, 10000) : fake()->numberBetween(1000, 5000));
            }
            if (is_null($character->defense)) {
                $character->defense = $character->rarity === 'Legendary' ? fake()->numberBetween(10000, 50000) : ($character->rarity === 'Epic' ? fake()->numberBetween(5000, 10000) : fake()->numberBetween(1000, 5000));
            }
            if (is_null($character->speed)) {
                $character->speed = $character->rarity === 'Legendary' ? fake()->numberBetween(10000, 50000) : ($character->rarity === 'Epic' ? fake()->numberBetween(5000, 10000) : fake()->numberBetween(1000, 5000));
            }

        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_character', 'character_id', 'user_id')
            ->withTimestamps();
    }
}
