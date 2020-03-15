<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;
use App\Entity\User;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        // $this->get('twig')->addGlobal('login', false);
        // return $this->render('default/index.html.twig', ['controller_name' => 'default controller']);
        $user = $this->getUser();
        if(isset($user))
            return $this->render('default/index.html.twig', ['login' => true]);
        else
            return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/users")
     */
    public function userSearch() {
        return $this->render('default/users.html.twig');
    }

    /**
     * @Route("/loggedin", name="loggedin")
     */
    public function loggedIn() {
        return $this->render('default/index.html.twig', ['login' => true]);
    }

    /**
     * @Route("/about")
     */
    public function about() {
        return $this->render('default/index.html.twig', ['controller_name' => 'about']);
    }

    /**
     * @Route("/news")
     */
    public function news() {
        return $this->render('default/index.html.twig', ['controller_name' => 'news']);
    }

    /**
     * @Route("/contacts")
     */
    public function contacts() {
        $contacts = $this->getContactsFile();
        $user = $this->getUser();
        if(isset($user))
            return $this->render('default/contacts.html.twig', ['contacts' => $contacts, 'login' => true]);
        else
            return $this->render('default/contacts.html.twig', ['contacts' => $contacts]);
    }

    /**
     * @Route("/admin")
     */
    public function admin() {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $emails = [];
        foreach($users as $email) {
            // echo $email->getEmail();
            array_push($emails, $email->getEmail());
        }

        $user = $this->getUser();
        if(isset($user))
            return $this->render('default/admin.html.twig', ['login' => true, 'emails' => $emails]);
        else
            return $this->render('default/admin.html.twig');
    }

    public function getContactsFile() {
        /*
            REMEBER THIS ONLY HANDLES SINGLE CONTACT, DOESN'T HANDLE MULTIPLE CONTACTS
            WILL NEED TO CHANGE contacts.html.twig TO LOOP THROUGH CONTACTS
        */
        $finder = new Finder();
        $finder->files()->in(__DIR__)->name('contacts.txt');
        foreach($finder as $file) {
            $contents = $file->getContents();
            // echo($contents);
            return $contents;
        }
    }
}
