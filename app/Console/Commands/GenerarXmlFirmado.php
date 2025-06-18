<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Facturas;
use App\Services\FirmaXmlGenerator;
use Illuminate\Support\Facades\DB;

class GenerarXmlFirmado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firma:xml-uno {numSerie}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $inicio = microtime(true);

        $carpetaOrigen = getenv('USERPROFILE') . '\facturas';
        $carpetaDestino = getenv('USERPROFILE') . '\facturasFirmadas';

        $numSerie = $this->argument('numSerie');

        $factura = Facturas::where('numSerieFactura', $numSerie)->first();

        if (!$factura) {
            $this->error("Factura con el ID $numSerie no fue encontrada");
            return;
        }

        

        $archivoXml = $carpetaOrigen . '\facturas_' . $numSerie . '.xml';

        if (!file_exists($archivoXml)) {
            $this->error("No existe el archivo XML para la factura $numSerie en $archivoXml");
            return;
        }

        $xmlContent = file_get_contents($archivoXml);


        $signer = new FirmaXmlGenerator();

        $xmlFirmado = $signer->firmaXml($xmlContent);
        //$id = $this->argument('id');
        $factura =  glob($carpetaOrigen . '\facturas_' . $numSerie);

        $firmaExiste = DB::table('facturas_firmadas')->where('num_serie_factura', $numSerie)->exists();

        $firmadoPath = $carpetaDestino . '\factura_firmada_' . $numSerie . '.xml';
        file_put_contents($firmadoPath, $xmlFirmado);

        $tiempoMs = intval((microtime(true) - $inicio) * 1000);

        if (!$firmaExiste) {
            DB::table('facturas_firmadas')->insert([
                'num_serie_factura' => $numSerie,
                'xml_firmado' => $xmlFirmado,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (!$firmaExiste) {
            DB::table('facturas_logs')->insert([
                'num_serie_factura' => $numSerie,
                'accion_firmado' => 'firmado',
                'tiempo_ms' => $tiempoMs,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $this->info('XML firmado correctamente');
    }
    
}
