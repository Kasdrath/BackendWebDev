<?php

namespace App\Http\Controllers;

use App\Repositories\TestRepository;
use Illuminate\Http\Request;
use App\Http\Requests\LibroRequest;

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
}
