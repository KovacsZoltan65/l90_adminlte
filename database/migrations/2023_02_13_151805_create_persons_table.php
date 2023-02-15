<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->comment('Személy adatok');
            $table->bigIncrements('id')->comment('Rekord azonosító');
            $table->string('name')->index('person_name_index')->comment('Személy neve');
            $table->integer('status')->default(1)->index()->comment('Státusz; 0 = törölt; 1 = aktív');
            $table->text('data')->nullable()->default('')->comment('Kapcsolódó adatok');
            $table->string('uuid', 36)->comment('Globális azonosító');
            $table->string('checksum', 32)->comment('Ellenörző összeg');
            $table->timestamps();
            $table->timestamp('syncronized_at')->nullable()->comment('Szinkronizálás dátuma');
            $table->softDeletes();
            $table->timestamp('status_changed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
};
