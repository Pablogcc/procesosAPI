<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Facturas;
use App\Models\Estado_procesos;
use App\Services\FacturaXmlGenerator;
use App\Services\FirmaXmlGenerator;
use Illuminate\Support\Facades\DB;

class ProcesarFacturasInsertadas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facturas:procesar-inserts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar facturas firmadas en XML';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $totalFacturas = 0;
        $totalTiempo = 0;

        $facturas = Estado_procesos::where('enviados', 'pendiente')
            ->where('estado_proceso', 'bloqueada')->get();

        foreach ($facturas as $factura) {
            $inicio = microtime(true);


            try {

                if (empty($factura->nombreRazon) || (strlen($factura->nombreRazonEmisor) < 3 || strlen($factura->nombreRazonEmisor) > 100)) {
                    throw new \Exception("El nombre es incorrecto. REVISAR FACTURA");
                }

                if (strlen($factura->nif) !== 9) {
                    throw new \Exception("El NIF es incorrecto. REVISAR FACTURA");
                }

                //Generar XML
                $xml = (new FacturaXmlGenerator())->generateXml($factura);

                //Guardamos el XML
                $carpetaOrigen = getenv('USERPROFILE') . '\facturas';

                $ruta = $carpetaOrigen . '\facturas_lock_' . $factura->numSerieFactura . '.xml';
                file_put_contents($ruta, $xml);

                //Firma del XML
                $xmlFirmado = (new FirmaXmlGenerator())->firmaXml($xml);

                //Guardamos el XML firmado
                $carpetaDestino = getenv('USERPROFILE') . '\facturasFirmadas';

                $rutaDestino = $carpetaDestino . '\factura_lock_firmada_' . $factura->numSerieFactura . '.xml';

                file_put_contents($rutaDestino, $xmlFirmado);

                //Guardado en base de datos
                $exists = DB::table('facturas_firmadas')->where('num_serie_factura', $factura->numSerieFactura)->exists();
                if (!$exists) {
                    DB::table('facturas_firmadas')->insert([
                        'num_serie_factura' => $factura->numSerieFactura,
                        'xml_firmado' => $xmlFirmado,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }



                //Cambiamos estado
                $factura->enviados = 'enviado';
                $factura->estado_proceso = 'procesada';
                $factura->save();

                $tiempoMs = intval((microtime(true) - $inicio) * 1000);
                $totalFacturas++;
                $totalTiempo += $tiempoMs;
            } catch (\Throwable $e) {
                $factura->error = $e->getMessage();
                $factura->enviados = 'error';
                $this->error("Error procesando factura {$factura->numSerieFactura}: " . $e->getMessage());
                continue;
            }
        }


        if ($totalFacturas > 0) {
            $mediaTiempo = intval($totalTiempo / $totalFacturas);
            DB::table('facturas_logs')->insert([
                'cantidad_facturas' => $totalFacturas,
                'media_tiempo_ms' => $mediaTiempo,
                'periodo' => now()->startOfMinute(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info('XML firmados correctamente');
    }
}
