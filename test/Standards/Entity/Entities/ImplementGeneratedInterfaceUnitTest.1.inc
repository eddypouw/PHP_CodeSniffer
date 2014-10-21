<?php
namespace Hostnet\Invoice\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hostnet\Component\EntityGenerator as HN;

class AdministrativeCost implements Generated\AdministrativeCostInterface
{
    use Generated\AdministrativeCostTraits;
    use Generated\AdministrativeCostMethodsTrait;

}