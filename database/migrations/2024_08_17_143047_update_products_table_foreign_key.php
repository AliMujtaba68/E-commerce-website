<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTableForeignKey extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop existing foreign key constraint
            $table->dropForeign(['subcategory_id']);

            // Add new foreign key constraint with ON DELETE SET NULL
            $table->foreign('subcategory_id')
                  ->references('id')->on('subcategories')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['subcategory_id']);

            // Restore the original foreign key constraint without ON DELETE rule
            $table->foreign('subcategory_id')
                  ->references('id')->on('subcategories')
                  ->onDelete('restrict'); // or 'cascade' depending on your needs
        });
    }
}
