<?php
namespace App\EventSubscriber;

use App\Entity\Article;
use App\Entity\Job;
use App\Entity\Project;
use Cocur\Slugify\Slugify;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class EasyAdminSubscriber implements EventSubscriberInterface
{


    public function __construct()
    {
    }

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.pre_persist' => [
                ["setJobSlug",10],
                ["setProjectSlug",15],
                ["setArticleSlug",20]
            ],
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

    public function setArticleSlug(GenericEvent $event)
    {

        $entity = $event->getSubject();

        if (!($entity instanceof Article)) {
            return;
        }

        $slugifyTitle = new Slugify();
        $entity->setSlug($slugifyTitle->slugify($entity->getTitle()));

        $event['entity'] = $entity;

    }
}
