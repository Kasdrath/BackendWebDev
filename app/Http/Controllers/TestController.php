<?php

namespace App\Http\Controllers;

use App\Repositories\TestRepository;
use Illuminate\Http\Request;
use App\Http\Requests\LibroRequest;
use App\Http\Requests\GenericRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class TestController extends Controller
{
    protected TestRepository $testRepo;
    public function __construct(TestRepository $testRepo)
    {
        $this->testRepo = $testRepo;
    }

    public function listarLibros()
    {
        return $this->testRepo->listarLibros();
    }

    public function guardarLibros(LibroRequest $request)
    {
        return $this->testRepo->guardarLibros($request);
    }


    public function filtrarLibros(Request $request)
    {
        return $this->testRepo->filtrarLibros($request);
    }

    public function actualizarLibro(Request $request)
    {
        return $this->testRepo->actualizarLibro($request);
    }

    public function eliminarLibro(Request $request)
    {
        return $this->testRepo->eliminarLibro($request);
    }

    public function eliminarcomentarioLibro(Request $request)
    {
        return $this->testRepo->eliminarcomentarioLibro($request);
    }


    public function testing(GenericRequest $request)
    {
        Log::info($request->all());
        return response()->json([$request->all()], Response::HTTP_OK);
    }


    public function Trabajillo(Request $request)
    {
        return $this->testRepo->Trabajillo($request);
    }
}
