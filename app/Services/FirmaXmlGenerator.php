<?php

namespace App\Services;

use App\Models\Facturas;
use App\Services\DOMDocument;
use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;

class FirmaXmlGenerator
{

    public function firmaXml(string $xmlContent)
    {
        $pfxPath = storage_path(env('PFX_CERT_PATH'));
        $pfxPassword = env('PFX_CERT_PASSWORD');
        $certStore = [];

        if (!openssl_pkcs12_read(file_get_contents($pfxPath), $certStore, $pfxPassword)) {
            throw new \Exception("Error al leer el archivo");
        }

        $privateKey = $certStore['pkey'];
        $publicCert = $certStore['cert'];

        $doc = new \DOMDocument();
        $doc->loadXML($xmlContent);

        $objDSig = new XMLSecurityDSig();
        $objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
        $objDSig->addReference(
            $doc,
            XMLSecurityDSig::SHA256,
            array('http://www.w3.org/2000/09/xmldsig#enveloped-signature')
        );
        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, array('type'=>'private'));
        $objKey->loadKey($privateKey, false);
        $objDSig->sign($objKey);
        $objDSig->add509Cert($publicCert);
        $objDSig->appendSignature($doc->documentElement);

        return $doc->saveXML();
    }
}
