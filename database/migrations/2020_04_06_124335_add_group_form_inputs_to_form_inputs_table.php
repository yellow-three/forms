<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupFormInputsToFormInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE form_inputs CHANGE COLUMN `type` `type` ENUM('text', 'number', 'email', 'text_area', 'checkbox', 'select', 'radio', 'file', 'submit', 'group') NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE form_inputs CHANGE COLUMN `type` `type` ENUM('text', 'number', 'email', 'text_area', 'checkbox', 'select', 'radio', 'file') NOT NULL");
    }
}
