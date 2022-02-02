<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Customers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('track_id')->unique();
            $table->string('nama_customer');
            $table->string('alamat');
            $table->string('telepon');
            $table->string('email')->nullable();
            $table->integer('nomor_internet');
            $table->string('odp_bookingan');
            $table->string('odp_alternatif')->nullable();
            $table->string('koordinat');
            $table->foreignIdFor(App\Models\Channel::class);
            $table->foreignIdFor(App\Models\Status::class)->nullable();
            $table->foreignIdFor(App\Models\Distribution::class);
            $table->foreignIdFor(App\Models\Mitra::class)->nullable();
            $table->foreignIdFor(App\Models\Team::class)->nullable();
            $table->string('qrcode')->nullable();
            $table->text('deskripsi')->nullable();
            // $table->foreignIdFor(App\Models\User::class, 'created_by');
            $table->foreignIdFor(App\Models\User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('customers');
    }
}
