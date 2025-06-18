<?php

namespace App\Console\Commands;

use App\Services\FirmaXmlGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class GenerarXmlFirmados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firma:xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar Xml firmado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $carpetaOrigen = getenv('USERPROFILE') . '\facturas';
        $carpetaDestino = getenv('USERPROFILE') . '\facturasFirmadas';

        $signer = new FirmaXmlGenerator();

        foreach (glob($carpetaOrigen . '\facturas_*.xml') as $archivo) {

            $inicio = microtime(true);

            $xmlContent = file_get_contents($archivo);
            $xmlFirmado = $signer->firmaXml($xmlContent);

            $firmadoPath = $carpetaDestino . '\firmado_' . basename($archivo);
            file_put_contents($firmadoPath, $xmlFirmado);
            $this->info("El Xml fue firmado");

            $nombre = basename($archivo, '.xml');
            $numSerie = str_replace('facturas_', '', $nombre);

            $firmaExiste = DB::table('facturas_firmadas')->where('num_serie_factura', $numSerie)->exists();
             
            if (!$firmaExiste) {
                DB::table('facturas_firmadas')->insert([
                    'num_serie_factura' => $numSerie,
                    'xml_firmado' => $xmlFirmado,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $tiempoMs = intval((microtime(true) - $inicio) * 1000);
              if (!$firmaExiste) {
                DB::table('facturas_logs')->insert([
                    'num_serie_factura' => $numSerie,
                    'accion_firmado' => 'firmado',
                    'tiempo_ms' => $tiempoMs,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
              }
        }

        $this->info('Todos los xml han sido firmados');
    }
}
