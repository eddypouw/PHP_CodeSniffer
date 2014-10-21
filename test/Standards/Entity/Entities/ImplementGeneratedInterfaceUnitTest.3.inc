<?php
namespace Hostnet\Invoice\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hostnet\Component\EntityBlamable\Blamable;
use Hostnet\Component\EntityBlamable\BlamableInterface;
use Hostnet\Component\EntityGenerator as HN;
use Hostnet\Invoice\Entity\Generated;

class Agreement implements Generrated\AgreementInterface, BlamableInterface
{
    
}