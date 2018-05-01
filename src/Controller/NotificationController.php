<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Notification;
use App\Entity\User;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class NotificationController extends Controller
{
    /**
     * @Route("/api/checkSubAndNews")
     */
    public function checkSubAndNews(Request $request)
    {
        $userId = $request->query->get('userId');
        if($userId != null){
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($userId);

            $events = $user->getAlreadyPlayedEvent();
            $tomorrow = new DateTime("tomorrow");
            $now = new DateTime("now");
            $tempEvent = new Event();
            /**@var $event Event*/
            foreach ($events as $event){
                if($event->getDateOfEvent() <  $tomorrow){
                    $notification = $em->getRepository(Notification::class)
                        ->findByEventAndUser($event->getId(),$userId);
                    if($notification == null){
                        $notification = new Notification();
                        $notification->setDataOfCreate($now);
                        $notification->setEventid($event->getId());
                        $notification->setUserid($userId);
                        $em->persist($notification);
                        $tempEvent = $event;
                        break;
                    }
                }
            }
            $em->flush();


            return new JsonResponse([
                "answerMessage" => "ok",
                "notificationTitle" => "tomorrow",
                "notificationText" => "Will be ".$tempEvent->getTitle(),
            ]);
        }
        return new JsonResponse([
            "answerMessage" => "not ok",
            "notificationTitle" => "",
            "notificationText" => "",
        ]);
    }
}
