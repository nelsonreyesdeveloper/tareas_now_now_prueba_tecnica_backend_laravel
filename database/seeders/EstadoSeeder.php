<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estados')->insert([
         [
             'id' => 1,
             'nombre' => 'Pendiente',
         ],
         [
             'id' => 2,
             'nombre' => 'En Proceso',
         ],[
             'id' => 3,
             'nombre' => 'Bloqueado',
         ] ,[
             'id' => 4,
             'nombre' => 'Completado',
         ]  
        ]);
    }
}
