<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Curso;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $curso1=Curso::create([
            'nombre_curso'=> 'LARAVEL',
            'descripcion'=> 'CRUD AJAX'
        ]);
        $curso2=Curso::create([
            'nombre_curso'=> 'DJANGO',
            'descripcion'=> 'PYTHON DJANGO'
        ]);
    }
}
