<?php

namespace App\Services;

use App\Models\Estado_procesos;
use DOMDocument;

class FacturaXmlGenerator
{

    public function generateXml(Estado_procesos $factura)
    {

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $facturaElement = $dom->createElement('Facturas');
        //Campos iniciales
        $facturaElement->appendChild($dom->createElement('idVersion', $factura->idVersion));
        $facturaElement->appendChild($dom->createElement('idEmisorFactura', $factura->idEmisorFactura));
        $facturaElement->appendChild($dom->createElement('numSerieFactura', $factura->numSerieFactura));
        $facturaElement->appendChild($dom->createElement('fechaExpedicionFactura', $factura->fechaExpedicionFactura));
        $facturaElement->appendChild($dom->createElement('refExterna', $factura->refExterna));
        $facturaElement->appendChild($dom->createElement('nombreRazonEmisor', $factura->nombreRazonEmisor));
        $facturaElement->appendChild($dom->createElement('subsanacion', $factura->subsanacion));
        $facturaElement->appendChild($dom->createElement('rechazoPrevio', $factura->rechazoPrevio));
        $facturaElement->appendChild($dom->createElement('tipoFactura', $factura->tipoFactura));

        //Facturas Rectificadas
        $facturaElement->appendChild($dom->createElement('idEmisorFacturaRectificada', $factura->idEmisorFacturaRectificada));
        $facturaElement->appendChild($dom->createElement('numSerieFacturaRectificada', $factura->numSerieFacturaRectificada));
        $facturaElement->appendChild($dom->createElement('fechaExpedicionFacturaRectificada', $factura->fechaExpedicionFacturaRectificada));

        //Facturas Sustituidas
        $facturaElement->appendChild($dom->createElement('idEmisorFacturaSustituida', $factura->idEmisorFacturaSustituida));
        $facturaElement->appendChild($dom->createElement('numSerieFacturaSustituida', $factura->numSerieFacturaSustituida));
        $facturaElement->appendChild($dom->createElement('fechaExpedicionFacturaSustituida', $factura->fechaExpedicionFacturaSustituida));
        $facturaElement->appendChild($dom->createElement('baseRectificada', $factura->baseRectificada));
        $facturaElement->appendChild($dom->createElement('cuotaRectificada', $factura->cuotaRectificada));
        $facturaElement->appendChild($dom->createElement('cuotaRecargoRectificado', $factura->cuotaRecargoRectificado));
        $facturaElement->appendChild($dom->createElement('fechaOperacion', $factura->fechaOperacion));
        $facturaElement->appendChild($dom->createElement('descripcionOperacion', $factura->descripcionOperacion));
        $facturaElement->appendChild($dom->createElement('facturaSimplificadaArt7273', $factura->facturaSimplificadaArt7273));
        $facturaElement->appendChild($dom->createElement('facturaSinIdentifDestinatarioArt61d', $factura->facturaSinIdentifDestinatarioArt61d));
        $facturaElement->appendChild($dom->createElement('macrodato', $factura->macrodato));
        $facturaElement->appendChild($dom->createElement('emitidaPorTerceroODestinatario', $factura->emitidaPorTerceroODestinatario));
        
        //Datos del destinatario
        $facturaElement->appendChild($dom->createElement('nombreRazon', $factura->nombreRazon));
        $facturaElement->appendChild($dom->createElement('nif', $factura->nif));
        $facturaElement->appendChild($dom->createElement('codigoPais', $factura->codigoPais));
        $facturaElement->appendChild($dom->createElement('idType', $factura->idType));
        $facturaElement->appendChild($dom->createElement('id', $factura->id));

        //Datos fiscales
        $facturaElement->appendChild($dom->createElement('cupon', $factura->cupon));
        $facturaElement->appendChild($dom->createElement('impuesto', $factura->impuesto));
        $facturaElement->appendChild($dom->createElement('claveRegimen', $factura->claveRegimen));
        $facturaElement->appendChild($dom->createElement('calificacionOperacion', $factura->calificacionOperacion));
        $facturaElement->appendChild($dom->createElement('operacionExenta', $factura->operacionExenta));
        $facturaElement->appendChild($dom->createElement('tipoImpositivo', $factura->tipoImpositivo));
        $facturaElement->appendChild($dom->createElement('baseImponibleOimporteNoSujeto', $factura->baseImponibleOimporteNoSujeto));
        $facturaElement->appendChild($dom->createElement('baseImponibleACoste', $factura->baseImponibleACoste));
        $facturaElement->appendChild($dom->createElement('cuotaRepercutida', $factura->cuotaRepercutida));
        $facturaElement->appendChild($dom->createElement('tipoRecargoEquivalencia', $factura->tipoRecargoEquivalencia));
        $facturaElement->appendChild($dom->createElement('cuotaRecargoEquivalencia', $factura->cuotaRecargoEquivalencia));
        $facturaElement->appendChild($dom->createElement('cuotaTotal', $factura->cuotaTotal));
        $facturaElement->appendChild($dom->createElement('importeTotal', $factura->importeTotal));
        $facturaElement->appendChild($dom->createElement('primerRegistro', $factura->primerRegistro));
        
        //Registro adicional
        $facturaElement->appendChild($dom->createElement('huella', $factura->huella));
        $facturaElement->appendChild($dom->createElement('fechaHoraHusoGenRegistro', $factura->fechaHoraHusoGenRegistro));
        $facturaElement->appendChild($dom->createElement('numRegistroAcuerdoFacturacion', $factura->numRegistroAcuerdoFacturacion));
        $facturaElement->appendChild($dom->createElement('idAcuerdoSistemaInformatico', $factura->idAcuerdoSistemaInformatico));
        $facturaElement->appendChild($dom->createElement('tipoHuella', $factura->tipoHuella));
        
        $dom->appendChild($facturaElement);

        return $dom->saveXML();
    }
}
