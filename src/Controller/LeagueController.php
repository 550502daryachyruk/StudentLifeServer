<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\League;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LeagueController extends Controller
{
    /**
     * @Route("/api/createChildLeague")
     */
    public function index(Request $request)
    {
        //TODO add checking for access


        $nameOfLeague = $request->request->get('leagueName');
        $description = $request->request->get('description');
        $idParentLeague = $request->request->get('parentLeagueId');
        $nameOfCurrency = $request->request->get('nameOfCurrency');
        $userId = $request->request->get('userId');
//            $file = $request->files->get ( 'photo' );
//            $fileName = md5 ( uniqid () ) . '.' . $file->guessExtension ();
        if ($nameOfCurrency != null || $nameOfLeague != null && $description != null && $userId != null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($userId);
            if ($idParentLeague == null) {
                $idParentLeague = 1;
            }
            $league = new League();
            $parent = $em->getRepository(League::class)->find($idParentLeague);
            $league->setParentLeague($parent);
            $league->setName($nameOfLeague);
            $league->setDescription($description);
            $league->setNameOfCurrency($nameOfCurrency);
            $user->addLeaguesWhereAdmin($league);
            $em->persist($league);
            $em->flush();
            //   $league->setParentLeague($em->getRepository(League::class)->findOneBy(["name" => $parentLeague]));
            return new JsonResponse(array("response" => 'create'));
        } else {
            return new JsonResponse(array("response" => 'not create'));
        }
        return new JsonResponse('test');

    }


    /**
     * @Route("/api/getLeagues/")
     */
    public function getListOfLeagues(Request $request)
    {
        //TODO add checking for access

        $id = $request->request->get('userId');
        //$id = $request->query->get('userId');
        if ($id != null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($id);
            if ($user === null) {

            }
            $leagues = $user->getLeaguesWhereUser();
            $massive = [];
            $massive1 = [];
            foreach ($leagues as $league) {
                $massive[] = $league->getId();
                $massive1[] = $league->getName();
            }
            return $this->json(["indexes" => $massive, "names" => $massive1]);
        } else {
            return $this->json("Nothing");
        }
    }

    /**
     * @Route("/api/getListOfEvent/")
     */
    public function getListOfEvent(Request $request)
    {
//        if ($request->request->get('leagueId')) {
//            $id = $request->request->get('leagueId');
//        }
        if ($request->query->get('leagueId')) {
            $id = $request->query->get('leagueId');
        }
        $userId = $request->query->get('userId');
        if ($id != null || $userId != null) {
            $em = $this->getDoctrine()->getManager();
            $league = $em->getRepository(League::class)->find($id);
            $user = $em->getRepository(User::class)->find($userId);
            $roleOfUser = 0;
            foreach ($user->getLeaguesWhereUser() as $leag) {
                if ($leag->getId() == $id) {
                    $roleOfUser = 2;
                    break;
                }
            }
            if ($roleOfUser == 0) {
                foreach ($user->getLeaguesWhereAdmin() as $leag) {
                    if ($leag->getId() == $id) {
                        $roleOfUser = 3;
                        break;
                    }
                }
            }

            $events = $league->getEvents();
            $descriptions = [];
            $indexes = [];
            $amountOfLikes = [];
            $isLiked = [];
            $data = [];
            $time = [];

            foreach ($events as $event) {
                $descriptions[] = $event->getDescription();
                $indexes[] = $event->getId();
                $amountOfLikes[] = $event->getAmauntOfLike();
                $isLiked[] = $event->isUserLike($user);
                $data[] = $event->getDateOfEvent()->format('Y-m-d');
                $time[] = $event->getDateOfEvent()->format('H:i:s');
            }
            return new JsonResponse(array(
                'role' => $roleOfUser,
                'index' => $indexes,
                'description' => $descriptions,
                'likeNumber' => $amountOfLikes,
                'isLiked' => $isLiked,
                'eventData' => $data,
                'eventTime' => $time

            ));
        } else {
            return new JsonResponse('Nothing');
        }
    }

    /**
     * @Route("/api/userEvents/")
     */
    public function getListOfUserEvents(Request $request)
    {
        $id = -1;
        if ($request->request->get('userId')) {
            $id = $request->request->get('userId');
        }
        if ($request->query->get('userId')) {
            $id = $request->query->get('userId');
        }
        if ($id != -1) {

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($id);
            $events = $user->getAlreadyPlayedEvent();
            $leagues = [];
            $descriptions = [];
            $indexes = [];
            $amountOfLikes = [];
            $isLiked = [];
            $data = [];
            $time = [];

            /**@var $event Event */
            foreach ($events as $event) {
                $leagues[] = $event->getTargetLeague()->getName();
                $descriptions[] = $event->getDescription();
                $indexes[] = $event->getId();
                $amountOfLikes[] = $event->getAmauntOfLike();
                $isLiked[] = $event->isUserLike($user);
                $data[] = $event->getDateOfEvent()->format('Y-m-d');
                $time[] = $event->getDateOfEvent()->format('H:i:s');
            }
            return new JsonResponse(array('index' => $indexes,
                'description' => $descriptions,
                'league' => $leagues,
                'likeNumber' => $amountOfLikes,
                'isLiked' => $isLiked,
                'eventData' => $data,
                'eventTime' => $time
            ));
        } else {
            return new JsonResponse('Nothing');
        }
    }

    /**
     * @Route("/api/getAllUsersOfLeague")
     */
    public function getAllUsersOfLeague(Request $request)
    {
        $id = $request->query->get('leagueId');

        if ($id != null) {
            $em = $this->getDoctrine()->getManager();
            $league = $em->getRepository(League::class)->find($id);
            $users = $league->getUsers();

            $ids = [];
            $names = [];


            /**
             * @var $user User
             */
            foreach ($users as $user) {
                $names[] = $user->getUsername();
                $ids[] = $user->getId();
            }
            return new JsonResponse(['name' => $names, 'id' => $ids]);
        }
        return new JsonResponse('Nothing');
    }


    /**
     * @Route("/api/unsubscribeLeague")
     */
    public function unsubscribeLeague(Request $request)
    {
        $leagueId = $request->request->get('leagueId');
        if ($leagueId == 1) {
            return new JsonResponse(['answer' => "Can't go from first league"]);
        }
        $userId = $request->request->get('userId');

        if ($leagueId != null && $userId != null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($userId);
            $league = $em->getRepository(League::class)->find($leagueId);
            if ($user->getLeaguesWhereUser()->contains($league)) {
                $user->removeLeaguesWhereUser($league);
                $em->flush();
            }
            return new JsonResponse(['answer' => "OK"]);
        }
        return new JsonResponse(['answer' => "Not enough parametres"]);
    }

    /**
     * @Route("/api/subscribeLeague")
     */
    public function subscribeLeague(Request $request)
    {
        $leagueId = $request->request->get('leagueId');
        $userId = $request->request->get('userId');

        if ($leagueId != null && $userId != null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($userId);
            $league = $em->getRepository(League::class)->find($leagueId);
            if ($league != null && $user != null) {
                if (!$user->getLeaguesWhereUser()->contains($league) && !$user->getLeaguesWhereAdmin()->contains($league)) {

                    if ($league->getParentLeague()->getUsers()->contains($user)) {
                        $user->addLeaguesWhereUser($league);
                        $em->flush();
                        return new JsonResponse(['answer' => "OK"]);
                    } else return new JsonResponse(['answer' => "Must be subscriber of parent league"]);
                }
            } else
                return new JsonResponse(['answer' => "This user or league not found"]);
        }
        return new JsonResponse(['answer' => "Not enough parametres"]);
    }

    /**
     * @Route("/api/likeIncrement")
     */
    public function inclementLike(Request $request)
    {
        $eventId = $request->request->get('eventId');
        $userId = $request->request->get('userId');
        if ($userId != null && $eventId != null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($userId);
            $event = $em->getRepository(Event::class)->find($eventId);
            if (!$user->isEventsLiked($event)) {
                $user->addEventsLiked($event);
            } else {
                return new JsonResponse(['answer' => "Already liked"]);
            }
            $em->flush();
            return new JsonResponse(['answer' => "ok"]);
        }
        return new JsonResponse(['answer' => "Not enough parametres"]);
    }

    /**
     * @Route("/api/likeDecrement")
     */
    public function decrementLike(Request $request)
    {
        $eventId = $request->request->get('eventId');
        $userId = $request->request->get('userId');
        if ($userId != null && $eventId != null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($userId);
            $event = $em->getRepository(Event::class)->find($eventId);
            if ($user->isEventsLiked($event)) {
                $user->removeEventsLiked($event);
            } else {
                return new JsonResponse(['answer' => "Not liked yet"]);
            }
            $em->flush();
            return new JsonResponse(['answer' => "ok"]);
        }
        return new JsonResponse(['answer' => "Not enough parametres"]);
    }

    /**
     * @Route("/api/getOwnEvents")
     */
    public function getOwnEvents(Request $request)
    {
        $userId = $request->query->get('userId');
        if($userId != null){
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($userId);

            $events = $user->getCreatedEvent();
            $indexes = [];
            $titles = [];
            $eventData = [];
            $eventTime = [];
            $leagueName = [];
            /** @var $event Event */
            foreach ($events as $event){
                $leagueName[] = $event->getTargetLeague()->getName();
                $indexes[] = $event->getId();
                $eventData[] = $event->getDateOfEvent()->format('Y-m-d');
                $eventTime[] = $event->getDateOfEvent()->format('H:i:s');
                $titles[] = $event->getTitle();
            }
            return new JsonResponse([
                'answer' => "ok",
                'eventName' => $titles,
                'eventDate' => $eventData,
                'eventTime' => $eventTime,
                'leagueName' => $leagueName,
            ]);


        }
        return new JsonResponse(['answer' => "Not enough parametres"]);

    }
}