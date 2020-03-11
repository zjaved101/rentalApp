<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', ['controller_name' => 'default controller']);
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
        return $this->render('default/contacts.html.twig', ['contacts' => $contacts]);
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
