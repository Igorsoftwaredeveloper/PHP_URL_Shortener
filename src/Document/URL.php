<?php
namespace App\Document;

use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document(collection: 'URLs')]
class URL
{
    #[ODM\Id]
    public ?string $id = null;

    #[ODM\Field]
    public string $site;

    #[ODM\Field]
    public string $shortKey;
}
