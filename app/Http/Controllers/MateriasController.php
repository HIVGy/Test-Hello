<?php

namespace App\Http\Controllers;

use App\Models\Materias;
use Illuminate\Http\Request;

class MateriasController extends Controller
{
    //Regresa los registros de las materias con paginación
    public function list()
    {
        $materias = Materias::latest()->get();
        return $materias;
    }

    //Almacenar una nueva materia
    public function store(Request $request)
    {
        $camposValidados = $request->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'creditos' => 'required|numeric',
            'descripcion' => 'required',
        ]);

        $save = Materias::create($camposValidados);

        if ($save) {
            $response = [
                'success' => true,
                'message' => 'Materia agregada correctamente',
            ];
            return response()->json($response, 201);
        }

        $response = [
            'success' => false,
            'message' => 'Ha ocurrido un error, intentalo de nuevo',
        ];
        return response()->json($response, 200);
    }

    //Editar una materia existente
    public function update(Request $request)
    {
        $camposValidados = $request->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'creditos' => 'required',
            'descripcion' => 'required',
        ]);

        $materia = Materias::find($request->id);
        $save = $materia->update($camposValidados);

        if ($save) {
            $response = [
                'success' => true,
                'message' => 'Materia editada correctamente',
            ];
            return response()->json($response, 200);
        }

        $response = [
            'success' => false,
            'message' => 'Ha ocurrido un error, intentalo de nuevo',
        ];
        return response()->json($response, 200);
    }

    //Eliminar una materia
    public function destroy(Request $request)
    {
        $materia = Materias::find($request->id);
        $delete = $materia->delete();

        if ($delete) {
            $response = [
                'success' => true,
                'message' => 'Materia eliminada exitosamente',
            ];
            return response()->json($response, 200);
        }

        $response = [
            'success' => false,
            'message' => 'Ha ocurrido un error, intentalo de nuevo',
        ];
        return response()->json($response, 200);
    }
}
