<?php

use App\Models\Task;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function (Blueprint $table) {
			$table->id('id');
			$table->foreignId('project_id')->constrained()->onDelete('cascade');
			$table->string('title')->index();
			$table->string('description', 2048);
			$table->string('notes', 2048)->nullable();
			$table->string('feedback', 2048)->nullable();
			$table->string('created_by')->index();
			$table->decimal('estimate', 8, 2);
			$table->enum('status', Task::STATUSES)->index();
			$table->timestamps();
			$table->softDeletes();
			$table->uuid('uuid')->index();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('tasks');
	}
}
