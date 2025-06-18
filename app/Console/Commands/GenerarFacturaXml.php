<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Facturas;
use App\Services\FacturaXmlGenerator;

class GenerarFacturaXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // Este es el comando para generar el Xml(php artisan factura:xml ID12345)
    protected $signature = 'factura:xml {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar Xml de la factura';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        $factura = Facturas::find($id);

       

        if(!$factura){
            $this ->error("Factura con el ID $id no fue encontrada");
            return;
        }

        $generator = new FacturaXmlGenerator();
        $xml = $generator->generateXml($factura);
        $nombre = $factura->numSerieFactura;
        $carpeta = getenv('USERPROFILE') . '\facturas';

        $ruta =  $carpeta . "\\facturas_{$nombre}.xml";
        file_put_contents($ruta, $xml);
        $this->info("El Xml fue generado correctamente en: $ruta");
    }
}
