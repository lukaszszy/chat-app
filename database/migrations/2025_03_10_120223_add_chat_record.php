<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use App\Services\OpenAIService;
use App\Models\Chat;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Uruchomienie migracji.
     */
    public function up()
    {
        for ($i = 1; $i <= 25; $i++) {
            $chat = Chat::create(['unique_id' => Hash::make($i),'email' => $i,]);
        }
    }

    /**
     * Cofnięcie migracji.
     */
    public function down()
    {
        for ($i = 1; $i <= 25; $i++) {
            Chat::where('unique_id', Hash::make($i))->delete();
        }
    }
};
