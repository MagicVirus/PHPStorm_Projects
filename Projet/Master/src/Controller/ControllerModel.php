<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\XSDValidator;
use App\Entity\Admin;
use App\Entity\Model;

class ControllerModel extends Controller{

  private $cookieID = "ID";
  private $loginKey = "username";
  private $passwordKey = "password";
  private $disconnectKey = "disconnect";

  private $signInMessage = "Sign In";
  private $loginErrorMessage = "Login Error";
  private $disconnectMessage = "Disconnected";
  private $signInAsAdminMessage = "Sign In As Admin";


  // <editor-fold defaultstate="collapsed" desc="routes">


  /**
  * @Route("/validate")
  */
  public function validateAction(Request $request){
    $user = new User();

    if($this->isUserConnected($user, $request)){
      return $this->sendToValidate($user->isAdmin(), null);
    }
    return $this->sendToLogin($this->signInMessage);
  }


  /**
  * @Route("/admin")
  */
  public function adminAction(Request $request){
    $user = new User();

    if($this->isUserConnected($user, $request)){
      if($user->isAdmin()){
        return $this->sendToAdmin($user, $this->actionHasBeenAskedByAdmin($request));
      }
    }
    return $this->sendToLogin($this->signInAsAdminMessage);
  }



  /**
  * @Route("/")
  */
  public function indexAction(Request $request){
    $user = new User();

    if($request->get($this->disconnectKey)){
      if($this->loginCookieIsSet($request)) {
        if ($user->isConnected($request->cookies->get($this->cookieID))) {
          $this->unsetUserCookie($user->getID());
          return $this->sendToLogin($this->disconnectMessage);
        }
      }
    }

    if($this->isUserConnected($user, $request)){
      return $this->sendToConnected($user);
    }

    if($this->credentialsAreSet($request)) {
      if ($user->connectUser($request->get($this->loginKey), $request->get($this->passwordKey))) {
        $this->setUserCookie($user->getID());
        return $this->sendToConnected($user);
      }
    }

    return $this->sendToLogin($this->loginErrorMessage);
  }

  /**
  * @Route("/validator")
  */
  public function validatorAction(Request $request){
    $user = new User();

    if($this->isUserConnected($user, $request)){
      return $this->sendToValidate($user->isAdmin(), $this->isModelValid($request));
    }

    return $this->sendToLogin($this->signInMessage);
  }

  // </editor-fold>


  private function actionHasBeenAskedByAdmin($request){
    $admin = new Admin();

    if($request->get("delUser") != null){
      $admin->removeUser($request->get("delUser"));
      return "User Deleted";
    }
    elseif($request->get("name") != null && $request->get("password") != null) {
      $admin->addUser($request->get("name"), $request->get("password"));
      return "User Added";
    }
    elseif($request->get("model") != null && $request->get("email") != null) {
      $model = new Model();
      $model->setDescription($request->get("model"));
      $admin->addModel($model, $request->get("email"));
      return "Model Added";
    }
  }

  private function setUserCookie($id){
    setcookie($this->cookieID, $id, time()+3600);
  }

  private function isModelValid($request){
    $xsdValidator = new XSDValidator();
    //TODO: check if null before sending it to validator
    $xsdValidator->setXsd($request->get("XSD"));
    $xsdValidator->setXml($request->get("XML"));
    return $xsdValidator->isValid();
  }

  private function unsetUserCookie($id){
    setcookie($this->cookieID, $id, time()-100);
  }

  private function loginCookieIsSet(Request $request){
    return $request->cookies->has($this->cookieID);
  }

  private function credentialsAreSet(Request $request){
    return $request->get($this->loginKey) != null && $request->get($this->passwordKey) != null;
  }

  private function isUserConnected($user, $request){
    return $this->loginCookieIsSet($request) && $user->isConnected($request->cookies->get($this->cookieID));
  }

  // <editor-fold defaultstate="collapsed" desc="redirection">

  private function sendToValidate($isAdmin, $modelValidated){
    return $this->render('default/validate.php.twig', array(
      'isAdmin' => $isAdmin,
      'modelValidated' => $modelValidated
    ));
  }

  private function sendToConnected($user){
    return $this->render('default/model_list.php.twig', array(
      'isAdmin' => $user->isAdmin(),
      'models' => $user->getVisibleModels()
    ));
  }

  private function sendToLogin($errorMessage){
    return $this->render('login.html.twig', array(
      'errorMessage' => $errorMessage
    ));
  }

  private function sendToAdmin($user, $message){
    return $this->render('admin/admin.php.twig', array(
      'isAdmin' => $user->isAdmin(),
      'models' => $user->getVisibleModels(),
      'message' => $message
    ));
  }


  // </editor-fold>

}
