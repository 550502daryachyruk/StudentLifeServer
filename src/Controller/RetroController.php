<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Couchbase\Document;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RetroController extends Controller
{

    /**
     * @Route("/api/", name="api")
     */
    public function index(Request $request)
    {
        if ($request->request->get('message')) {
            return $this->json(["message" => "post response"]);
        }
        if ($request->query->get('message')) {
            return $this->json(["message" => "get response"]);
        }
        return $this->json("default");
    }

    /**
     * @Route("/api/form", name="form")
     */
    public function form(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $file = $user->getAvatarImage();
            //var_dump($file);
            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

            var_dump($file);
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );
            $user->setAvatarImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        return $this->render(
            'retro/index.html.twig',
            array('form' => $form->createView())
//         $file = $this->getParameter('brochures_directory')."/8c007fa7b3e10c5fed577a103898bdd2.png";
//        var_dump($this->file($file));
//        return $this->render('retro/preview.html.twig',array(

        );

    }
    /**
     * @Route("/api/register", name="register")
     */
    public function register(Request $request, ValidatorInterface $validator)
    {
        if ($request->query->all()) {
            $em = $this->getDoctrine()->getManager();
            //$userManager = $em->getRepository(User::class);

            $user = new User();
            $firstName = $request->query->get('firstname');
            $lastName = $request->query->get('lastname');
            $userUsername = $request->query->get('username');
            $userEmail = $request->query->get('email');
            $userPassword = $request->query->get('password');
            $userSex = $request->query->get('sex');
            $userBirthday = \DateTime::createFromFormat('Y-m-d', $request->query->get('birthday'));
            $userImage = $request->get('attachment');
            if(!$userImage) {
                $user->setAvatarImage($this->getParameter('brochures_directory')."/default.jpg");
            }
            else{
                $fileName = $this->generateUniqueFileName() . '.' . $userImage->guessExtension();
                $userImage->move(
                    $this->getParameter('brochures_directory'),
                    $fileName
                );
                $user->setAvatarImage($fileName);
            }
            $user->setFirstname($firstName);
            $user->setLastname($lastName);
            $user->setUsername($userUsername);
            $user->setEmail($userEmail);
            $user->setPassword($userPassword);
            $user->setSex($userSex);
            $user->setBirthdayDate($userBirthday);

            $errors = $validator->validate($user);

            if (count($errors) > 0) {
                return new JsonResponse($this->jsonErrors('registration', $errors));
            } else {
                $em->persist($user);
                $em->flush();
                return new JsonResponse(array('type' => 'registration', 'error' => 'ok'));
            }
        }
        return new JsonResponse(array('type' => 'registration', 'error' => 'invalid arguments'));
    }

    /**
     * @Route("/api/login", name="login")
     */
    public function login(Request $request, ValidatorInterface $validator)
    {
        if ($request->query->all()) {
            //$em = $this->getDoctrine()->getManager();
            //$userManager = $em->getRepository(User::class);
            $authType = $request->query->get('auth_type');
            $password = $request->query->get('password');
            $errors = $validator->validate($authType,new\Symfony\Component\Validator\Constraints\Email());

            if (count($errors) > 0) {
                return new JsonResponse($this->jsonErrors('registration', $errors));
            } else {
                return new JsonResponse(array('type' => 'registration', 'error' => 'ok'));
            }
        }
        return new JsonResponse(array('type' => 'registration', 'error' => 'invalid arguments'));
    }

    public function jsonErrors(string $type, ConstraintViolationList $errors)
    {
        $arr = array('type' => $type);
        foreach ($errors as $error) {
            $arr['error'][] = $error->getMessage();
        }
        return $arr;
    }
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
