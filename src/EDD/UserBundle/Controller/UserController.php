<?php

namespace EDD\UserBundle\Controller;

use EDD\UserBundle\Entity\User;
use EDD\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {

    /**
     * @Route("/",name="index")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

    /**
     * @Route("/createUser",name="create_user")
     * @Template()
     */
    public function createUserAction(Request $request) {

        $user = new User();
        $form = $this->createForm(new UserType(),$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
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
     * @Route("/deleteUser",name="delete_user")
     * @Template()
     */
    public function deleteUserAction() {
        return array(// ...
        );
    }

    /**
     * @Route("/readUsers",name="readUsers")
     * @Template()
     */
    public function readUsersAction() {
        return array(// ...
        );
    }

    /**
     * @Route("/readUser",name="readUser")
     * @Template()
     */
    public function readUserAction() {
        return array(// ...
        );
    }

}
