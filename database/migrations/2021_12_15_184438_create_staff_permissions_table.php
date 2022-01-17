<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_permissions', function (Blueprint $table) {
            $table->id();
            $table->string("user_id");
            $table->boolean("users")->default(1);
            $table->boolean("pharmacies")->default(1);
            $table->boolean("orders")->default(1);
            $table->boolean("discounts")->default(1);
            $table->boolean("notifications")->default(1);
            $table->boolean("payments")->default(1);
            $table->boolean("products")->default(1);
            $table->boolean("settings")->default(1);
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
        Schema::dropIfExists('staff_permissions');
    }
}
