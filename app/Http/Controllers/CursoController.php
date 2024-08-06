<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('curso.index');
    }

    //creado por el usuario
    public function listar_cursos(Request $request)
    {
        //
        if($request->ajax()){
            // $cursos=Curso::all(); //Eloquent
            $cursos=DB::table('cursos')->select('*')->get();
            $html=view('curso.parent.ajax_lista_cursos', compact('cursos'))->render();
            return response()->json([
                'code'=>200,
                'html'=>$html,
                'msg'=>'success',                
            ],200);

        }else{
            return response()->json([
                'code'=>404,
                'msg'=>'error',
                'message'=>'Error, no se puede acceder a la pagina'
            ],404);
        }
    }
    // public function listar_cursos(Request $request)
    // {
    //     //
    //     if($request->ajax()){
    //         // $cursos=Curso::all(); //Eloquent
    //         $cursos=DB::table('cursos')->select('*')->get();
    //         $html=view('curso.parent.ajax_lista_cursos', compact('cursos'))->render();
    //         return response()->json([
    //             'code'=>200,
    //             'html'=>$html,
    //             'msg'=>'success',                
    //         ],200);

    //     }else{
    //         return response->json([
    //             'code'=>404,
    //             'msg'=>'error',
    //             'message'=>'Error, no se puede acceder a la pagina'
    //         ],404);
    //     }
    // }

    //
    public function registrar_curso(Request $request){
        if($request->ajax()){
            $tipo_form=$request->tipo_formulario;
            if($tipo_form==1){//crear
                $curso = Curso::create([
                    'nombre_curso' => $request -> nombre_curso,
                    'descripcion' => $request -> descripcion
                ]);    
                if($curso){
                    return response()->json([
                        'code'=>200,
                        // 'html'=>$html,
                        'msg'=>'success',        
                        'message'=>'Curso registrado exitosamente'        
                    ],200);    
                }else{
                    return response()->json([
                        'code'=>404,
                        'msg'=>'error',
                        'message'=>'Error, no se pudo registrar'
                    ],404);           
                }
            }else{//editar
                $id_curso=$request->id_curso_editar;
                //update por querybuilder
                DB::table('cursos')->where('id','=',$id_curso)->update([
                    'nombre_curso' => $request -> nombre_curso,
                    'descripcion' => $request ->descripcion                   
                ]);
                return response()->json([
                    'code'=>200,                    
                    'msg'=>'success',        
                    'message'=>'Curso actualizado'        
                ],200);
            };            
        }else{
            return response()->json([
                'code'=>404,
                'msg'=>'error',
                'message'=>'Error, no se puede acceder a la pagina'
            ],404);
        }
    }
    
    
    //editar cursos
    public function obtener_curso(Request $request){
        if($request->ajax()){
            $curso=Curso::find($request->id_curso);
            return response()->json([
                'code'=>200,                
                'msg'=>'success',        
                'message'=>'Curso encontrado',
                'curso'=> $curso        
            ],200);
        }else{
            return response()->json([
                'code'=>404,
                'msg'=>'error',
                'message'=>'Error, no se puede acceder a la pagina'
            ],404);
        }
    }

    //eliminar cursos
    public function eliminar_curso(Request $request)
    {
        // Verificar que la solicitud sea AJAX
        if ($request->ajax()) {
            // Obtener el ID del curso de la solicitud
            $id_curso = $request->input('id_curso');
    
            try {
                // Buscar el curso por ID
                $curso = Curso::findOrFail($id_curso);
    
                // Eliminar el curso
                $curso->delete();
    
                // Devolver una respuesta JSON de éxito
                return response()->json([
                    'success' => true,
                    'message' => 'Curso eliminado con éxito.'
                ], 200);
            } catch (\Exception $e) {
                // Devolver una respuesta JSON de error en caso de excepción
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el curso: ' . $e->getMessage()
                ], 500);
            }
        } else {
            // Devolver una respuesta JSON si la solicitud no es AJAX
            return response()->json([
                'success' => false,
                'message' => 'Error, no se puede acceder a la página.'
            ], 404);
        }
    }
    

    // public function eliminar_curso(Request $request){
    //     if($request->ajax()){
    //         $curso=Curso::delete($request->id_curso);
    //         return response()->json([
    //             'code'=>200,                
    //             'msg'=>'success',        
    //             'message'=>'Curso eliminado'                       
    //         ],200);
    //     }else{
    //         return response()->json([
    //             'code'=>404,
    //             'msg'=>'error',
    //             'message'=>'Error, no se puede acceder a la pagina'
    //         ],404);
    //     }
    // }



        /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        //
    }
}
