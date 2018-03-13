<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\User;
use Symfony\Component\DependencyInjection\Tests\Compiler\J;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LeagueController extends Controller
{
    /**
     * @Route("/leagueAdding")
     */
    public function index(Request $request)
    {
        //TODO add checking for access

        $parentLeague = $request->query->get('parentLeague');
        var_dump($parentLeague);
        if($parentLeague != null)
        {
            $nameOfLeague = $request->query->get('nameOfLeague');
            $description = $request->query->get('description');
//            $file = $request->files->get ( 'photo' );
//            $fileName = md5 ( uniqid () ) . '.' . $file->guessExtension ();
            if($nameOfLeague != null && $description != null)
            {
                $em = $this->getDoctrine()->getManager();
                $league  = new League();
                $league->setAdmins([$this->getUser()]);
                $league->setParentLeague($em->getRepository(League::class)->findOneBy(["name" => $parentLeague]));
                return new Response('create');
            }
            return new Response('if');

        }
        return new Response('test');

    }


    /**
     * @Route("/api/getLeagues/")
     */
    public function getListOfLeagues(Request $request)
    {
        //TODO add checking for access

        $id = $request->request->get('userId');
        //$id = $request->query->get('userId');
        if($id != null)
        {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($id);
            $leagues = $user->getLeaguesWhereUser();
            $massive = [];
            $massive1 = [];
            //   var_dump($leagues);
            foreach($leagues as $league){
                //var_dump($league);
                $massive[] = $league->getId();
                $massive1[] = $league->getName();
            }
        //    var_dump($this->json($massive));
            return $this->json(["indexes" => $massive, "names" => $massive1]);
        }
        else{
            return $this->json("Nothing");
        }
    }

    /**
     * @Route("/api/getListOfEvent/")
     */
    public function getListOfEvent(Request $request)
    {
        $id = $request->request->get('leagueId');
        if($id != null)
        {
            $em = $this->getDoctrine()->getManager();
            $league = $em->getRepository(League::class)->find($id);
            $events = $league->getEvents();
            $descriptions = [];
            $indexes = [];
            foreach($events as $event){
                $descriptions[] = $event->getDescription();
                $indexes[] = $event->getId();
            }
            return new JsonResponse(array('index'=>$descriptions,'description'=>$indexes));
        }
        else{
            return new JsonResponse('Nothing');
        }
    }
}
