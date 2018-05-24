<?php

namespace App\Controller;

//use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use App\Entity\Place;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ControllerModel extends Controller{

    private function isAdmin(){
        return $this->isConnected() && true;
    }

    private function isConnected(){
        return false;
    }

    /**
     * @Route("/")
     */
    public function indexAction(){
        if($this->isConnected()){
            return $this->sendToConnected($this->isAdmin());
        }
        return $this->sendToLogin("Sign In");
    }

    /**
     * @Route("/validate")
     */
    public function validateAction(){
        if($this->isConnected()){
            return $this->sendToValidate($this->isAdmin());
        }
        return $this->sendToLogin("Sign In");
    }


    /**
     * @Route("/admin")
     */
    public function adminAction(){
        if($this->isAdmin()){
            return $this->render('admin/admin.php.twig');
        }
        return $this->sendToLogin("Sign In As Admin");
    }

    private function sendToLogin($errorMessage){
        return $this->render('login.html.twig', array(
            'errorMessage' => $errorMessage
        ));
    }

    private function sendToValidate($isAdmin){
        return $this->render('default/validate.php.twig', array(
            'isAdmin' => $isAdmin,
        ));
    }

    private function sendToConnected($isAdmin){
        return $this->render('default/model_list.php.twig', array(
            'isAdmin' => $isAdmin,
        ));
    }
    public function getPlacesAction(Request $request){
        return new JsonResponse([
            new Place("Tour Eiffel", "5 Avenue Anatole France, 75007 Paris"),
            new Place("Mont-Saint-Michel", "50170 Le Mont-Saint-Michel"),
            new Place("Château de Versailles", "Place d'Armes, 78000 Versailles"),
        ]);
    }
}