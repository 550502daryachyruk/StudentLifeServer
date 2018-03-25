<?php

namespace App\Controller;

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
     * @Route("/api/createChildLeague/")
     */
    public function index(Request $request)
    {
        //TODO add checking for access


            $nameOfLeague = $request->request->get('leagueName');
            $description = $request->request->get('description');
            $idParentLeague = $request->request->get('parentLeagueId');
//            $file = $request->files->get ( 'photo' );
//            $fileName = md5 ( uniqid () ) . '.' . $file->guessExtension ();
            if ($nameOfLeague != null && $description != null && $idParentLeague != null) {
                $em = $this->getDoctrine()->getManager();
                $league = new League();
                $league->setParentLeague($idParentLeague);
                $league->setName($nameOfLeague);

                $league->setAdmins([$this->getUser()]);
                $em->persist($league);
                $em->flush();
             //   $league->setParentLeague($em->getRepository(League::class)->findOneBy(["name" => $parentLeague]));
                return new JsonResponse(array("response" => 'create'));
            }
            else {
                return new JsonResponse(array("response" =>'not create'));
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
            $leagues = $user->getLeaguesWhereUser();
            $massive = [];
            $massive1 = [];
            //   var_dump($leagues);
            foreach ($leagues as $league) {
                //var_dump($league);
                $massive[] = $league->getId();
                $massive1[] = $league->getName();
            }
            //    var_dump($this->json($massive));
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
        if ($request->request->get('leagueId')) {
            $id = $request->request->get('leagueId');
        }
        if ($request->query->get('leagueId')) {
            $id = $request->query->get('leagueId');
        }
        if ($id != null) {
            $em = $this->getDoctrine()->getManager();
            $league = $em->getRepository(League::class)->find($id);
            $events = $league->getEvents();
            $descriptions = [];
            $indexes = [];
            foreach ($events as $event) {
                $descriptions[] = $event->getDescription();
                $indexes[] = $event->getId();
            }
            return new JsonResponse(array('index' => $indexes, 'description' => $descriptions));
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
        if ($id != null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($id);
            $events = $user->getAlreadyPlayedEvent();
            $leagues = [];
            $descriptions = [];
            $indexes = [];
            foreach ($events as $event) {
                $leagues[] = $event->getTargetLeague()->getName();
                $descriptions[] = $event->getDescription();
                $indexes[] = $event->getId();
            }
            return new JsonResponse(array('index' => $indexes, 'description' => $descriptions,'league'=>$leagues));
        } else {
            return new JsonResponse('Nothing');
        }
    }
}
