<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnInMyTabl
{
    public function handle()
    {
        Schema::table('businesses', function($table) use ($oldColumn, $newColumn){
                $table->renameColumn($oldColumn, $newColumn);
            });
    }
}