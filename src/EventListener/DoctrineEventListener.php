<?php

namespace App\EventListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;

//CHECK SERVIVCES.YAML !

class DoctrineEventListener
{
    // the listener methods receive an argument which gives you access to
    // both the entity object of the event and the entity manager itself

    
    public function preUpdate(LifecycleEventArgs $args): void
    {
        // Qu'importe le type d'entite, si doctrine voit qu'il y a un update a faire,
        // il va declencher cette methode preUpdate() avant de vraiment faire la requete UPDATE en BDD

        //When Doctrine see that you want to update a update request on an entity ( like updatedAt ), Doctrine will fire up this preUpdate() method BEFORE executing the request itself
        
        // this methods create a generic Entity with his methods and properties
        $entity = $args->getObject();

        // if the $entity got a certain method, the following code applies, else nothing happens and no error messages show up

        
        if (method_exists($entity, 'setUpdatedAt')) {
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
    }
}