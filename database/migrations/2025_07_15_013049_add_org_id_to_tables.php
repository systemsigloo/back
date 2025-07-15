<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add org_id to categorias
        Schema::table('categorias', function (Blueprint $table) {
            $table->unsignedBigInteger('org_id')->nullable()->after('id');
            $table->foreign('org_id')->references('id')->on('org')->onDelete('set null');
        });

        // Add org_id to detalle_pedidos
        Schema::table('detalle_pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('org_id')->nullable()->after('id');
            $table->foreign('org_id')->references('id')->on('org')->onDelete('set null');
        });

        // Add org_id to pedidos
        Schema::table('pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('org_id')->nullable()->after('id');
            $table->foreign('org_id')->references('id')->on('org')->onDelete('set null');
        });

        // Add org_id to productos
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedBigInteger('org_id')->nullable()->after('id');
            $table->foreign('org_id')->references('id')->on('org')->onDelete('set null');
        });



        // Add org_id to users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('org_id')->nullable()->after('id');
            $table->foreign('org_id')->references('id')->on('org')->onDelete('set null');
        });
    }

    public function down(): void
    {
        // Drop foreign keys and columns in reverse order to avoid constraint issues
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['org_id']);
            $table->dropColumn('org_id');
        });

    

        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['org_id']);
            $table->dropColumn('org_id');
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign(['org_id']);
            $table->dropColumn('org_id');
        });

        Schema::table('detalle_pedidos', function (Blueprint $table) {
            $table->dropForeign(['org_id']);
            $table->dropColumn('org_id');
        });

        Schema::table('categorias', function (Blueprint $table) {
            $table->dropForeign(['org_id']);
            $table->dropColumn('org_id');
        });
    }
};