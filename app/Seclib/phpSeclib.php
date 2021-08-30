<?php
namespace App\Seclib;
use phpseclib3\File\X509;

class phpSeclib
{
    protected $x509;
    protected $certificate;
    protected $pathFile;

    public function __construct($pathFile)
    {
        $this->pathFile = $pathFile;
        $this->x509 = new X509();    
        $this->certificate = $this->x509->loadX509(file_get_contents($this->pathFile));        
    }

    public function getDN()
    {
        return $this->certificate['tbsCertificate']['issuer']['rdnSequence'][4][0]['value']['printableString'];
    }

    public function getIssuerDN()
    {
        return $this->certificate['tbsCertificate']['issuer']['rdnSequence'][3][0]['value']['printableString'];
    }

    public function getExpirationDate()
    {
        return date( "Y-m-d", strtotime($this->certificate['tbsCertificate']['validity']['notAfter']['utcTime']));
    }
}