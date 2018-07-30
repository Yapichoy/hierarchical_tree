<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('surname',70);// Фамилия
            $table->string('name',70); // Имя
            $table->string('secondname',70); // Отчество
            $table->integer('position_id')->unsigned(); // id должности
            $table->date('date_start_work'); // Дата приема на работу
            $table->double('salary'); // Зарплата
            $table->integer('chef_id')->unsigned(); // id начальника
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
