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
        Schema::create('products_log', function (Blueprint $table) {
            $table->comment('Személy ardhiv adatok');
            $table->bigIncrements('id')->comment('Rekord azonosító');
            $table->timestamp('mod_date')->useCurrentOnUpdate()->useCurrent()->comment('Módosítás dátuma');
            $table->enum('mod_op', ['I', 'U', 'SD', 'R', 'D'])->comment('Módosítás típusa I = insert; U = update; SD = soft delete; R = restore; D = delete');
            $table->integer('p_id')->nullable()->comment('"products" rekord azonosító');
            $table->string('name')->nullable()->comment('Személy neve');
            $table->integer('status')->nullable()->comment('Státusz; 0 = törölt; 1 = aktív');
            $table->text('data')->nullable()->comment('Kapcsolódó adatok');
            $table->string('uuid', 36)->nullable()->comment('Globális azonosító');
            $table->string('checksum', 32)->nullable()->comment('Ellenörző összeg');
            $table->timestamp('created_at')->nullable()->comment('Keletkezés dátuma');
            $table->timestamp('updated_at')->nullable()->comment('Módosítás dátuma');
            $table->timestamp('syncronized_at')->nullable();
            $table->softDeletes()->comment('Törlés dátuma');
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
        Schema::dropIfExists('products_log');
    }
};
