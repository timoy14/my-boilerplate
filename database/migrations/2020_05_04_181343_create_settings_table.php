<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('about_us');
            $table->text('about_us_ar');
            $table->text('terms_and_conditions');
            $table->text('terms_and_conditions_ar');
            $table->text('contact_us');
            $table->text('contact_us_ar');
            $table->text('general_cancellation_policy_en');
            $table->text('general_cancellation_policy_ar');
            $table->integer('tax_rate')->default(5);
            $table->integer('app_commission')->default(15);
            $table->integer('admin_commission')->default(15);
            $table->integer('driver_commission')->default(15);
            $table->integer('delivery_fee_less_than_5_km')->default(5);
            $table->integer('delivery_fee_5_to_10_km')->default(10);
            $table->integer('delivery_fee_more_than_10_km')->default(11);
            $table->integer('cancellation_time_limit')->default(5);
            $table->string('account_name')->nullable();
            $table->string('account_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('settings');
    }
}