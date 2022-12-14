<?php

namespace App\Repositories;

use App\Jobs\Trabajillo;
use App\Models\Genero;
use App\Models\Libro;
use App\Models\Comentario;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class TestRepository
{
    public function listarLibros()
    {
        $libros = Libro::all();
        $generos = Genero::all();
        return response()->json(["libros" => $libros, "generos" => $generos], Response::HTTP_OK);
    }
    public function filtrarLibros($request)
    {
        Log::info(["el request--> " => $request->all()]);

        $libros = Libro::where('id', $request->id)->with(['genero', 'comentario'])
            ->get();

        //$filtrarlibro = Libro::whereIn('id',[1,5])->get();
        $entrelibros = Libro::whereBetween('id', [1, 4])->get();

        return response()->json(
            ["libros" => $libros, /*"filtradolibros" => $filtrarlibro*/ "entreLibros" => $entrelibros],
            Response::HTTP_OK
        );
    }

    public function guardarLibros($request)
    {
        $libros = new Libro();
        $libros->libr_autor = $request->autor;
        $libros->libr_titulo = $request->titulo;
        $libros->genero_id = $request->genero_id;
        $libros->save();
        return response()->json(["libros" => $libros], Response::HTTP_OK);
    }

    public function actualizarLibro($request)
    {
        try {
            $libros = Libro::findorFail($request->id);
            isset($request->titulo) && $libros->libr_titulo = $request->titulo;
            isset($request->genero) && $libros->genero_id = $request->genero;
            $libros->save();

            $libros = Libro::where('id', $request->id)
                ->update([
                    'libr_titulo' => $request->titulo,
                    'genero_id' => $request->genero_id
                ]);


            return response()->json(["libros" => $libros], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::info([
                "error" => $e,
                "mensaje" => $e->getMessage(),
                "linea" => $e->getLine(),
                "archivo" => $e->getFile(),
            ]);
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


    public function eliminarLibro($request)
    {
        try {
            $libros = Libro::find($request->id)->delete();
            return response()->json(["libros" => $libros], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminarcomentarioLibro($request)
    {
        try {
            $comentario = Comentario::find($request->id)->delete();
            return response()->json(["comentarios" => $comentario], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function Trabajillo($request)
    {
        $Libros = Libro::all();
        try {

            foreach ($Libros as $libro) {
                Trabajillo::dispatch($libro)->onQueue('ejemplo');
            }
            return response()->json(["se esta ejecutando"], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e], Response::HTTP_BAD_REQUEST);
        }
    }
}
