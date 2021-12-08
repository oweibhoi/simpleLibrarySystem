<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrow_lists', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('borrowerID');
            $table->tinyInteger('bookID');
            $table->date('borrowed_date');
            $table->tinyInteger('isReturn')->default('0');
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
        Schema::dropIfExists('borrow_lists');
    }
}
