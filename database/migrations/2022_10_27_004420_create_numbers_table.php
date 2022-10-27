<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('numbers', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'approved_id')->nullable()->constrained('users');
            $table->integer('value');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->text('observations')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('numbers');
    }
};
