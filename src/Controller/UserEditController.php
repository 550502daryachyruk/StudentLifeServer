<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserEditController extends Controller
{
    /**
     * @Route("api/user/edit", name="user_edit")
     */
    public function user_edit(Request $request,ValidatorInterface $validator)
    {
        if ($request->request->get('id')) {
            $id = $request->request->get('id');
        }
        if ($request->query->get('id')) {
            $id = $request->query->get('id');
        }
        if ($id != null) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($id);

            $user->setEmail($request->query->get('email'));
            $user->setPassword($request->query->get('password'));
            $user->setFirstname($request->query->get('firstname'));
            $user->setLastname($request->query->get('lastname'));

            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                return new JsonResponse($this->jsonErrors('edit', $errors));
            } else {
                $em->flush();
                return new JsonResponse(array('type' => 'edit', 'error' => 'ok'));
            }
        }
    }
    /**
     * @Route("api/user/view", name="user_view")
     */
    public function user_view(Request $request)
    {
        $id = null;
        if ($request->request->get('id')) {
            $id = $request->request->get('id');
        }
        if ($request->query->get('id')) {
            $id = $request->query->get('id');
        }
        if ($id != null) {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $email = $user->getEmail();
        $password = $user->getPassword();
        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        return new JsonResponse(array('email'=>$email,'password'=>$password,
            'firstname'=>$firstname,'lastname'=>$lastname));
    }
    else{
            return new JsonResponse('error');
        }
    }
    public function jsonErrors(string $type, ConstraintViolationList $errors)
    {
        $arr = array('type' => $type);
        foreach ($errors as $error) {
            $arr['error'][] = $error->getMessage();
        }
        return $arr;
    }
}
