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
     * @Route("/api/getListOfLeagueShopProducts")
     */
    public function index(Request $request)
    {
        $userId = $request->query->get('userId');
        $leagueId = $request->query->get('leagueId');

        if ($userId !== null && $leagueId !== null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($userId);
            $listOfBought1 = $user->getBoughtItems();
            $listOfBought = [];
            /**@var $item Items */
            $currency = $user->getCurrencysById($leagueId);
            foreach ($listOfBought1 as $item) {
                if ($item->getTargetLeague()->getId() == $leagueId) {
                    $listOfBought[] = $item;
                }
            }

            $league = $em->getRepository(League::class)->find($leagueId);
            $listOfItems = $league->getItems();
            if ($league == null || $user == null) {
                return new JsonResponse(array('answer' => "Not found User or League"));
            }
            $listOfNotBought = [];
            /**@var $everyItem Items */
            /**@var $boughtItem Items */
            foreach ($listOfItems as $everyItem) {
                $flag = true;
                foreach ($listOfBought as $boughtItem) {
                    if ($boughtItem->getId() == $everyItem->getId()) {
                        $flag = false;
                        break;
                    }
                }
                if ($flag === true) {
                    $listOfNotBought[] = $everyItem;
                }
            }

            $index = [];
            $price = [];
            $name = [];
            $description = [];
            /**@var $item Items */
            foreach ($listOfNotBought as $item) {
                $index[] = $item->getId();
                $price[] = $item->getPrice();
                $name[] = $item->getName();
                $description[] = $item->getDescription();
            }

            $index1 = [];
            $price1 = [];
            $name1 = [];
            $description1 = [];
            foreach ($listOfBought as $item) {
                $index1[] = $item->getId();
                $price1[] = $item->getPrice();
                $name1[] = $item->getName();
                $description1[] = $item->getDescription();
            }
            return new JsonResponse(array("NotBought" => ["index" => $index, "name" => $name, "price" => $price, "description" => $description],
                    "BoughtItems" => ["index" => $index1, "name" => $name1, "price" => $price1, "description" => $description1],
                    "currency" => $currency->getValue()
                )
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

        if ($userId != null && $leagueId != null && $valueOfcurrency != null) {

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($userId);

            $currencys = $user->getCurrencys();

            $currency = new Currency();

            /**@var $cur Currency */
            //Find currency to needed league
            foreach ($currencys as $cur) {
                if ($cur->getLeaguesId() == $leagueId) {
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
     * @Route("/api/buyingItem/")
     */
    public function buyingItem(Request $request)
    {
        $userId = $request->request->get('userId');
        $itemId = $request->request->get('itemId');

        if ($userId != null && $itemId != null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($userId);
            $item = $em->getRepository(Items::class)->find($itemId);
            $league = $item->getTargetLeague();
            $currency = $user->getCurrencysById($league->getId());

            /**  @var $currency Currency */
            if ($currency == null || $currency->getValue() < $item->getPrice()) {
                return new JsonResponse(["answer" => "Not enough money"]);
            }
            $user->addBoughtItems($item);
            $currency->setValue($currency->getValue() - $item->getPrice());
            $em->flush();
            return new JsonResponse(["answer" => "OK"]);
        } else return new JsonResponse(["answer" => "Not enough parametres"]);
    }
}
