<?php
namespace App\EventSubscriber;

use App\Entity\Job;
use Cocur\Slugify\Slugify;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Entity\Project;

class EasyAdminSubscriber implements EventSubscriberInterface
{


    public function __construct()
    {
    }

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.pre_persist' => array('setProjectSlug','setJobSlug'),
        );
    }

    public function setProjectSlug(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!($entity instanceof Project)) {
            return;
        }

        $slugifyTitle = new Slugify();
        $entity->setSlug($slugifyTitle->slugify($entity->getTitle()));

        $event['entity'] = $entity;
    }

    public function setJobSlug(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!($entity instanceof Job)) {
            return;
        }

        $slugifyTitle = new Slugify();
        $entity->setSlug($slugifyTitle->slugify($entity->getTitle()));

        $event['entity'] = $entity;
    }
}
