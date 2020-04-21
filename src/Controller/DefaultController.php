<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
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

        $firstName = $request->request->get('firstName');
        $lastName = $request->request->get('lastName');
        $homePhone = $request->request->get('homePhone');
        $cellPhone = $request->request->get('cellPhone');
        $email = $request->request->get('email');
        $data = [];
        $search = '';
        $key = '';
        if($firstName) {
            $search = $firstName;
            $key = "first";
        }
        if($lastName){
            $search = $lastName;
            $key = "last";
        }
        if($homePhone) {
            $search = $homePhone;
            $key = "home";
        }
        if($cellPhone){
            $search = $cellPhone;
            $key = "cell";
        }
        if($email) {
            $search = $email;
            $key = "email";
        }
        
        $users = $this->getDoctrine()->getRepository(User::class)->findKey($search, $key);
        if($users) {
            foreach($users as $user) {
                array_push($data, $user->getFirstName().' '.$user->getLastName() . ':' . $user->getHomePhone() . ':' . $user->getCellPhone() . ':' . $user->getEmail());
            }
        }
        
        if(isset($loggedIn))
            return $this->render('default/results.html.twig', ['users' => $data, 'login' => true]);
        else
            return $this->render('default/results.html.twig', ['users' => $data]);
    }

    /**
     * @Route("/rental")
     */
    public function rental(Request $request) {
        // if(isset($user))
        //     return $this->render('default/rental.html.twig', ['login' => true]);
        // else
        //     return $this->render('default/rental.html.twig');
        $user = $this->getUser();
        if(isset($user))
            $response = $this->render('default/rental.html.twig', ['login' => true]);
        else
            $response = $this->render('default/rental.html.twig');

        // $response->headers->setCookie(new Cookie('test', 'testValue'));
        $this->setRecentCookie($request, $response, 'Rental');
        $this->setPopularCookie($request, $response, 'Rental');
        return $response;
    }

    /**
     * @Route("/buy/car")
     */
    public function buyCar(Request $request) {
        $user = $this->getUser();
        if(isset($user))
            $response = $this->render('default/buyCars.html.twig', ['login' => true]);
        else
            $response = $this->render('default/buyCars.html.twig');

        $this->setRecentCookie($request, $response, 'Buy A Car');
        $this->setPopularCookie($request, $response, 'Buy A Car');
        return $response;
    }

    /**
     * @Route("/sell/car")
     */
    public function sellCar(Request $request) {
        $user = $this->getUser();
        if(isset($user))
            $response = $this->render('default/sellCars.html.twig', ['login' => true]);
        else
            $response = $this->render('default/sellCars.html.twig');

        $this->setRecentCookie($request, $response, 'Sell A Car');
        $this->setPopularCookie($request, $response, 'Sell A Car');
        return $response;
    }

    /**
     * @Route("/buy/accessory")
     */
    public function buyAccessory(Request $request) {
        $user = $this->getUser();
        if(isset($user))
            $response = $this->render('default/buyAccessory.html.twig', ['login' => true]);
        else
            $response = $this->render('default/buyAccessory.html.twig');

        $this->setRecentCookie($request, $response, 'Buy Accessories');
        $this->setPopularCookie($request, $response, 'Buy Accessories');
        return $response;
    }

    /**
     * @Route("/sell/accessory")
     */
    public function sellAccessory(Request $request) {
        $user = $this->getUser();
        if(isset($user))
            $response = $this->render('default/sellAccessory.html.twig', ['login' => true]);
        else
            $response = $this->render('default/sellAccessory.html.twig');

        $this->setRecentCookie($request, $response, 'Sell Accessories');
        $this->setPopularCookie($request, $response, 'Sell Accessories');
        return $response;
    }

    /**
     * @Route("/buy/parts")
     */
    public function buyParts(Request $request) {
        $user = $this->getUser();
        if(isset($user))
            $response = $this->render('default/buyParts.html.twig', ['login' => true]);
        else
            $response = $this->render('default/buyParts.html.twig');

        $this->setRecentCookie($request, $response, 'Buy Car Parts');
        $this->setPopularCookie($request, $response, 'Buy Car Parts');
        return $response;
    }

    /**
     * @Route("/sell/parts")
     */
    public function sellParts(Request $request) {
        $user = $this->getUser();
        if(isset($user))
            $response = $this->render('default/sellParts.html.twig', ['login' => true]);
        else
            $response = $this->render('default/sellParts.html.twig');

        $this->setRecentCookie($request, $response, 'Sell Car Parts');
        $this->setPopularCookie($request, $response, 'Sell Car Parts');
        return $response;
    }

    /**
     * @Route("/tune")
     */
    public function tune(Request $request) {
        $user = $this->getUser();
        if(isset($user))
            $response = $this->render('default/tune.html.twig', ['login' => true]);
        else
            $response = $this->render('default/tune.html.twig');

        $this->setRecentCookie($request, $response, 'Tune Your Car');
        $this->setPopularCookie($request, $response, 'Tune Your Car');
        return $response;
    }

    /**
     * @Route("/repair")
     */
    public function repair(Request $request) {
        $user = $this->getUser();
        if(isset($user))
            $response = $this->render('default/repair.html.twig', ['login' => true]);
        else
            $response = $this->render('default/repair.html.twig');

        $this->setRecentCookie($request, $response, 'Repair Your Car');
        $this->setPopularCookie($request, $response, 'Repair Your Car');
        return $response;
    }

    /**
     * @Route("/learn")
     */
    public function learn(Request $request) {
        $user = $this->getUser();
        if(isset($user))
            $response = $this->render('default/learn.html.twig', ['login' => true]);
        else
            $response = $this->render('default/learn.html.twig');

        $this->setRecentCookie($request, $response, 'Learn');
        $this->setPopularCookie($request, $response, 'Learn');
        return $response;
    }

    /**
     * @Route("/recent")
     */
    public function recent(Request $request) {
        $recent = $this->getRecentCookie($request);
        $user = $this->getUser();
        if(isset($user))
            return $this->render('default/recent.html.twig', ['login' => true, 'recent' => $recent]);
        else
            return $this->render('default/recent.html.twig', ['recent' => $recent]);
    }

    /**
     * @Route("/popular")
     */
    public function popular(Request $request) {
        $popular = $this->getPopularCookie($request);
        $user = $this->getUser();
        if(isset($user))
            return $this->render('default/popular.html.twig', ['login' => true, 'popular' => $popular]);
        else
            return $this->render('default/popular.html.twig', ['popular' => $popular]);
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
     * @Route("/getlistofusers")
     */
    public function getListOfUsers(Request $request) {
        // $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        // $emails = [];
        // foreach($users as $email) {
        //     if("admin@email.com" != $email->getEmail())
        //         array_push($emails, $email->getEmail());
        // }

        // $emails = $this->getAllEmails();
        $users = $this->getUserObjects();

        $response = new Response();
        $response->setContent(json_encode([
            'users' => $users,
        ]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/listofusers")
     */
    public function listOfUsers(Request $request) {
        $users = $this->getUserObjects();
        $mindcrunch = $this->curlUsers();
        // $mindcrunch = json_decode($mindcrunch);

        $user = $this->getUser();
        if(isset($user))
            return $this->render('default/listOfUsers.html.twig', ['users' => $users, 'mindcrunch' => $mindcrunch, 'login' => true]);
        else
            return $this->render('default/listOfUsers.html.twig', ['users' => $users, 'mindcrunch' => $mindcrunch]);
    }

    /**
     * @Route("/clear")
     */
    public function clear(Request $request) {
       $user = $this->getUser();
        if(isset($user))
            $response = $this->render('default/index.html.twig', ['login' => true]);
        else
            $response = $this->render('default/index.html.twig');

        $response->headers->clearCookie('recent');
        $response->headers->clearCookie('popular');
        return $response;
    }

    /**
     * @Route("/cookies")
     */
    public function cookies(Request $request) {
        $cookies = $request->cookies;
        print_r(unserialize($cookies->get('recent')));
        print_r(unserialize($cookies->get('popular')));

    }

    /**
     * @Route("/admin")
     */
    public function admin() {
        $emails = $this->getAllEmails();

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

    public function setRecentCookie(Request $request, Response $response, String $page) {
        $cookies = $request->cookies;
        if (!$cookies->has('recent')) {
            $recent = array();
        } else
            $recent = unserialize($cookies->get('recent'));

        if(count($recent) > 4) {
            unset($recent[0]);
            $recent = array_values($recent);
        }
        array_push($recent, $page);
        $response->headers->setCookie(new Cookie('recent', serialize($recent), time() + 3600));
    }

    public function getRecentCookie(Request $request) {
        $cookies = $request->cookies;
        if (!$cookies->has('recent')) 
            $recent = array();
        else
            $recent = unserialize($cookies->get('recent'));

        return $recent;
    }

    public function setPopularCookie(Request $request, Response $response, String $page) {
        $cookies = $request->cookies;
        if (!$cookies->has('popular')) {
            $popular = array();
        } else
            $popular = unserialize($cookies->get('popular'));

        if(!array_key_exists($page, $popular))
            $popular[$page] = 0;

        $popular[$page]++;
        $response->headers->setCookie(new Cookie('popular', serialize($popular), time() + 3600));
    }

    public function getPopularCookie(Request $request) {
        $cookies = $request->cookies;
        if (!$cookies->has('popular')) 
            $popular = array();
        else
            $popular = unserialize($cookies->get('popular'));

        arsort($popular);
        $top5 = array_slice($popular, 0, 5, true);
        return array_keys($top5);
    }

    /**
     * Returns a list of all user emails from database
     */
    public function getAllEmails() {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $emails = [];
        foreach($users as $email) {
            if("admin@email.com" != $email->getEmail())
                array_push($emails, $email->getEmail());
        }

        return $emails;
    }

    public function getUserObjects() {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $objects = [];
        foreach($users as $user) {
            if("admin@email.com" != $user->getEmail()) {
                $arr = array("firstName" => $user->getFirstName(), "lastName" => $user->getLastName(), "email" => $user->getEmail());
                array_push($objects, $arr);
            }
        }
        return $objects;
    }

    public function curlUsers() {
        // $fixieUrl = getenv("FIXIE_URL");
        $fixieUrl = getenv("http://fixie:dGJsfY3x4qrKabP@velodrome.usefixie.com:80");
        $parsedFixieUrl = parse_url($fixieUrl);

        $proxy = $parsedFixieUrl['host'].":".$parsedFixieUrl['port'];
        $proxyAuth = $parsedFixieUrl['user'].":".$parsedFixieUrl['pass'];

        $ch = curl_init("https://mindcrunch.com/all_users.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyAuth);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                'Accept: application/json',                                                                       
            )
        );
        $contents = curl_exec ($ch);
        curl_close ($ch);

        return json_decode($contents);

        // // LOCAL
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, "https://mindcrunch.com/all_users.php");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        //         'Accept: application/json',                                                                       
        //     )
        // );

        // $contents = curl_exec ($ch);
        // curl_close ($ch);

        // return json_decode($contents);
    }
}
