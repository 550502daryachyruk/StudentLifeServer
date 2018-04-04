<?php

namespace App\Controller;

use App\Entity\Currency;
use App\Entity\Items;
use App\Entity\League;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ItemController extends Controller
{
    /**
     * @Route("/api/GetItemsOfleagues", name="item")
     */
    public function index(Request $request)
    {
        $userId = $request->query->get('userId');
        $leagueId = $request->query->get('leagueId');

        if ($userId !== null && $leagueId !== null){
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($userId);
            $listOfBought = $user->getBoughtItems();

            $league =  $em->getRepository(League::class)->find($leagueId);
            $listOfItems = $league->getItems();
//TODO can't get arrays of item
            $listOfNotBought =  array_diff($listOfItems,$listOfBought);

            $index = [];
            $price = [];
            $name = [];
            /**@var $item Items */
            foreach ($listOfNotBought as $item ){
                $index[] = $item->getId();
                $price[] = $item->getPrice();
                $name[] = $item->getName();
            }

            $index1 = [];
            $price1 = [];
            $name1 = [];
            foreach ($listOfBought as $item ){
                $index1[] = $item->getId();
                $price1[] = $item->getPrice();
                $name1[] = $item->getName();
            }
            return new JsonResponse(array("AllItems" => ["index" => $index , "name" => $name , "price" => $price],
                                          "BoughtItems" =>  ["index" => $index1 , "name" => $name1 , "price" => $price1])
            );
        }
        return new JsonResponse(array("Nothing"));
    }



        /**
         * @Route("/api/giveUserCurrency")
         */
        public function giveUserCurrency(Request $request)
    {
        $userId = $request->request->get('userId');
        $leagueId = $request->request->get('leagueId');
        $valueOfcurrency = $request->request->get('valueOfcurrency');

        if($userId != null && $leagueId != null && $valueOfcurrency != null){

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($userId);

            $currencys = $user->getCurrencys();

            $currency = new Currency();

            /**@var $cur Currency*/
            //Find currency to needed league
            foreach ($currencys as $cur){
                if($cur->getLeaguesId() == $leagueId){
                    $currency = $cur;
                    break;
                }
            }
            $currency->setValue($currency->getValue() + $valueOfcurrency);

            $em->flush();
            return new JsonResponse(["answer" => "OK"]);
        }
        return new JsonResponse(["answer" => "Nothing"]);
    }





    /**
     * @Route("/api/buyItems")
     */
    public function buyItems(Request $request)
    {


    }

}
