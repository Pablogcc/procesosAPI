<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MuchasFacturasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            DB::table('facturas')->insert([
                'idVersion' => '1.0',
                'idEmisorFactura' => 'EMISOR' . $i,
                'numSerieFactura' => 'F2025-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'fechaExpedicionFactura' => now()->format('d-m-Y'),
                'refExterna' => 'REF' . $i,
                'nombreRazonEmisor' => 'Empresa S.A. ' . $i,
                'subsanacion' => 'L4',
                'rechazoPrevio' => 'L17',
                'tipoFactura' => 'L2',
                'idEmisorFacturaRectificada' => 'RECT' . $i,
                'numSerieFacturaRectificada' => 'FR2024-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'fechaExpedicionFacturaRectificada' => now()->subDays(10)->format('d-m-Y'),
                'idEmisorFacturaSustituida' => 'SUST' . $i,
                'numSerieFacturaSustituida' => 'FS2024-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'fechaExpedicionFacturaSustituida' => now()->subDays(20)->format('d-m-Y'),
                'baseRectificada' => rand(100, 999) + rand(0, 99)/100,
                'cuotaRectificada' => rand(10, 99) + rand(0, 99)/100,
                'cuotaRecargoRectificado' => rand(1, 9) + rand(0, 99)/100,
                'fechaOperacion' => now()->format('d-m-Y'),
                'descripcionOperacion' => 'Venta de productos ' . $i,
                'facturaSimplificadaArt7273' => 'L4',
                'facturaSinIdentifDestinatarioArt61d' => 'L5',
                'macrodato' => 'L14',
                'emitidaPorTerceroODestinatario' => 'L6',
                'nombreRazon' => 'Cliente S.L. ' . $i,
                'nif' => 'A' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'codigoPais' => 'ES',
                'idType' => 'L7',
                'id' => (string)$i,
                'cupon' => 'L4',
                'impuesto' => 'L1',
                'claveRegimen' => 'L8A',
                'calificacionOperacion' => 'L9',
                'operacionExenta' => 'L10',
                'tipoImpositivo' => 21.00,
                'baseImponibleOimporteNoSujeto' => 150.00 + $i,
                'baseImponibleACoste' => 140.00 + $i,
                'cuotaRepercutida' => 31.50 + $i,
                'tipoRecargoEquivalencia' => 5.20,
                'cuotaRecargoEquivalencia' => 7.80,
                'cuotaTotal' => 39.30 + $i,
                'importeTotal' => 189.30 + $i,
                'primerRegistro' => '1',
                'huella' => 'huella' . $i,
                'fechaHoraHusoGenRegistro' => now()->format('Y-m-d\TH:i:sP'),
                'numRegistroAcuerdoFacturacion' => 'REG' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'idAcuerdoSistemaInformatico' => 'SISTEMA' . $i,
                'tipoHuella' => 'L12',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
