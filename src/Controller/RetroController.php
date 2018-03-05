<?php

namespace App\Controller;

use http\Env\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RetroController extends Controller
{
    /**
     * @Route("/api/", name="retro")
     *
     */
    public function index(Request $request)
    {
        if($request->request->get('message')!=null)
        {
            return $this->json("ti post pidor");
        }
        if($request->query->get('message')!=null)
        {
            return $this->json(['key'=>"ty get pidor","you_message"=>$request->query->get('message')]);
        }
        return $this->json("ti pidor");
    }

    /**
     *
     * @Route("/login/", name="login",schemes={"https"})
     *
     */
    public function login(Request $request)
    {
//        $retrofit = Retrofit::builder()
//            ->setBaseUrl('http://api.82.209.228.129')
//            ->setHttpClient(new Guzzle6HttpClient(new Client()))
//            ->build();
//        $gitHubService = $retrofit->create(GitHubService::class);
//        //$call = $gitHubService->listRepos('octocat');
//        var_dump($gitHubService);
//        return $this->render('retro/index.html.twig', [
//            'controller_name' => 'RetroController',
//        ]);
        if($request->request->get('message')!=null)
        {
            return $this->json(['key'=>"ty post pidor","you_message"=>$request->request->get('message')]);
        }
        if($request->query->get('message')!=null)
        {
            return $this->json(['key'=>"ty get pidor","you_message"=>$request->query->get('message')]);
        }
        return $this->json("ti pidor");
    }
}
