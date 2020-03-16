<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

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
        $user = $this->getUser();
        if(isset($user))
            return $this->render('default/users.html.twig', ['login' => true]);
        else
            return $this->render('default/users.html.twig');
    }

    /**
     * @Route("/results")
     */
    public function results(Request $request) {
        $loggedIn = $this->getUser();

        $name = $request->request->get('name');
        $phone = $request->request->get('phone');
        $email = $request->request->get('email');
        $data = [];
        if($name) {
            $users = $this->getDoctrine()->getRepository(User::class)->findName($name);
            if($users) {
                foreach($users as $user) {
                    array_push($data, $user->getName() . ':' . $user->getPhone() . ':' . $user->getEmail());
                }
            }
        }
        elseif($phone) {
            $users = $this->getDoctrine()->getRepository(User::class)->findPhone($phone);
            if($users) {
                foreach($users as $user) {
                    array_push($data, $user->getName() . ':' . $user->getPhone() . ':' . $user->getEmail());
                }
            }
        }
        else {
            $users = $this->getDoctrine()->getRepository(User::class)->findEmail($email);
            if($users) {
                foreach($users as $user) {
                    array_push($data, $user->getName() . ':' . $user->getPhone() . ':' . $user->getEmail());
                }
            }
        }
        
        if(isset($loggedIn))
            return $this->render('default/results.html.twig', ['users' => $data, 'login' => true]);
        else
            return $this->render('default/results.html.twig', ['users' => $data]);
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
