<?php

namespace App\EventListener;

use App\Entity\Voiture;
use Doctrine\ORM\Event\LifecycleEventArgs;

class VoitureTokenListener
{
    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Voiture) {
            return;
        }
    }
}
