<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logins', function (Blueprint $table) {
            $table->id(); 
        
            $table->string('username')->unique(); 
            $table->string('password'); 
            // Additional fields, if required
            $table->string('first_name')->nullable(); // Nullable field for user's first name
            $table->string('last_name')->nullable(); // Nullable field for user's last name
            $table->string('email')->nullable(); // Nullable field for user's email address
            $table->boolean('is_active')->default(true); // A field to indicate whether the account is active or not
            $table->rememberToken(); // Used for "Remember Me" functionality, if needed
            $table->timestamps(); // Created_at and updated_at timestamps
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logins');
    }
}
