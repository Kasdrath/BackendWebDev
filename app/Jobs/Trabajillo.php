<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\EjemTrait;
use Illuminate\Support\Facades\Log;
use App\Models\Libro;


class Trabajillo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     * 
     * @return void
     */

    public $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            $trait = new EjemTrait();
            $foto = $trait->obtenerFoto();
            $this->request->titulo = $foto['message'];
            Log::info(["fotoxx" => $this->request->titulo]);

            //Log::info(["request en el handle" => $this->request]);
        } catch (Exception $e) {
            Log::info(["error" => $e->getMessage()]);
        }
    }
}
