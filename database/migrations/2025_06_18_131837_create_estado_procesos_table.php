<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estado_procesos', function (Blueprint $table) {
              // $table->id();
            $table->string('idVersion');
            $table->string('idEmisorFactura');
            $table->string('numSerieFactura');
            $table->string('fechaExpedicionFactura');
            $table->string('refExterna');
            $table->string('nombreRazonEmisor');
            $table->string('subsanacion');
            $table->string('rechazoPrevio');
            $table->string('tipoFactura');
            // Facturas Rectificadas
            $table->string('idEmisorFacturaRectificada');
            $table->string('numSerieFacturaRectificada');
            $table->string('fechaExpedicionFacturaRectificada');
            // Facturas Sustituidas
            $table->string('idEmisorFacturaSustituida');
            $table->string('numSerieFacturaSustituida');
            $table->string('fechaExpedicionFacturaSustituida');
            $table->decimal('baseRectificada', 10, 2);
            $table->decimal('cuotaRectificada', 10, 2);
            $table->decimal('cuotaRecargoRectificado', 10, 2);
            $table->string('fechaOperacion');
            $table->string('descripcionOperacion');
            $table->string('facturaSimplificadaArt7273');
            $table->string('facturaSinIdentifDestinatarioArt61d');
            $table->string('macrodato');
            $table->string('emitidaPorTerceroODestinatario');
            // Datos del destinatario
            $table->string('nombreRazon');
            $table->string('nif');
            $table->string('codigoPais');
            $table->string('idType');
            $table->string('id');
            // Datos fiscales
            $table->string('cupon');
            $table->string('impuesto');
            $table->string('claveRegimen');
            $table->string('calificacionOperacion');
            $table->string('operacionExenta');
            $table->decimal('tipoImpositivo', 10, 2);
            $table->decimal('baseImponibleOimporteNoSujeto', 10, 2);
            $table->decimal('baseImponibleACoste', 10, 2);
            $table->decimal('cuotaRepercutida', 10, 2);
            $table->decimal('tipoRecargoEquivalencia', 10, 2);
            $table->decimal('cuotaRecargoEquivalencia', 10, 2);
            $table->decimal('cuotaTotal', 10, 2);
            $table->decimal('importeTotal', 10, 2);
            $table->string('primerRegistro');
            // Registro adicional
            $table->string('huella');
            $table->string('fechaHoraHusoGenRegistro');
            $table->string('numRegistroAcuerdoFacturacion');
            $table->string('idAcuerdoSistemaInformatico');
            $table->string('tipoHuella');
            
            $table->string('enviados')->default('pendiente');
            $table->text('error')->nullable();
            $table->string('estado_proceso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_procesos');
    }
};
