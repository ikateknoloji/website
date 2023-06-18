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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_package_id')->constrained('service_packages')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities');
            $table->foreignId('district_id')->constrained('districts');
            $table->string('name');
            $table->string('field');
            $table->string('full_name');
            $table->string('motto');
            $table->string('phone');
            $table->string('email');
            $table->integer('establishment_year')->nullable();
            $table->text('about')->nullable();
            $table->text('project_content')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])
            ->default('pending');
            $table->decimal('offer_price', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
