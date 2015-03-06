<?php

namespace EDD\UserBundle\Controller;

use EDD\UserBundle\Entity\User;
use EDD\UserBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class UserController extends Controller {


    /**
     * @Route("/",name="index")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

    /**
     * @Route("/login",name="login")
     * @Template()
     */
    public function loginAction(Request $request) {
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return (
        array(
            'last_username' => $lastUsername,
            'error' => $error,
        )
        );
    }

    /**
     * @Route("/createUser",name="create_user")
     * @Template()
     */
    public function createUserAction(Request $request) {

        $user = new User();
        $form = $this->createForm(new UserType(), $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $encodeFactory = $this->container->get('security.encoder_factory');
            $encoder = $encodeFactory->getEncoder($user);
            $user->setPassword($encoder->encodePassword($request->get($form->getName())['password'], $user->getSalt()));
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('index'));

        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/deleteUser/{id}",name="delete_user")
     * @ParamConverter("user",class="EDDUserBundle:User")
     */
    public function deleteUserAction(User $user) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirect($this->generateUrl('readUsers'));
    }

    /**
     * @Route("/readUsers",name="readUsers")
     * @Template()
     */
    public function readUsersAction() {
        $users = $this->getDoctrine()->getRepository('EDDUserBundle:User')->findAll();
        return array(
            'users' => $users
        );
    }

    /**
     * @Route("/loadUserAjax",name="load_user_ajax",options={"expose"=true}))
     * @Template("EDDUserBundle:User:readUsers.html.twig")
     */
    public function usersAjaxAction(Request $request) {

        if ($request->isXmlHttpRequest()) {
            $from = $request->get('total_users'); //param from load.js
            $users = $this->getDoctrine()->getRepository('EDDUserBundle:User')->findBy(array(), null, User::NUM_ITEMS, $from);
            $response = new JsonResponse();
            try {
                $out_json = array(
                    'status' => "OK",
                    'template' => $this->renderView('EDDUserBundle:User:showUser.html.twig', array('users' => $users)),
                    'show_btn' => count($users) === 0 ? false : true
                );
            } catch (\Exception $e) {
                $out_json = array(
                    'status' => "KO",
                    'error' => $e->getMessage(),
                );
            }
            $response->setData($out_json);

            return $response;
        } else {
            $users = $this->getDoctrine()->getRepository('EDDUserBundle:User')->findBy(array(), null, User::NUM_ITEMS, 0);
        }

        return array(
            'users' => $users
        );
    }

    /**
     * @Route("/readUser/{id}",name="readUser")
     * @Template()
     * @ParamConverter("user",class="EDDUserBundle:User")
     */
    public function readUserAction(User $user) {
        return array(
            'user' => $user
        );
    }


}
