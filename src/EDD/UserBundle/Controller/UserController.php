<?php

namespace EDD\UserBundle\Controller;

use EDD\UserBundle\Entity\User;
use EDD\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
    public function createUserAction() {

        $user = new User();
        $form = $this->createForm(new UserType(),$user);

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
