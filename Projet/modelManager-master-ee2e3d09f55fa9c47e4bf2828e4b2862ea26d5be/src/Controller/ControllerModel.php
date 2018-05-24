<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;

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
  private $xsd = "xsd";
  private $xml = "xml";

  private $signInMessage = "Sign In";
  private $loginErrorMessage = "Login Error";
  private $disconnectMessage = "Disconnected";
  private $signInAsAdminMessage = "Sign In As Admin";

  private $deleteUser = "delUser";
  private $userDeleted = "User Deleted";

  private $name = "name";
  private $password = "password";
  private $userAdded = "User Added";

  private $modelString = "model";
  private $email = "email";
  private $modelAdded = "Model Added To User";

  private $hour = 3600;
  private $invalidateCookie = 100;


  /**
  * @Route("/validate")
  */
  public function validateAction(Request $request){
    $user = new User();

    if($this->isUserConnected($user, $request) && $request->get($this->xsd) != null){
      if($request->get($this->xml) == null){
        return $this->sendToValidate($user->isAdmin(), $request->get($this->xsd), null, null);
      }
      return $this->sendToValidate($user->isAdmin(), $request->get($this->xsd), $request->get($this->xml), $this->isModelValid($request));
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

    return $this->sendToLogin($this->signInMessage);
  }

  private function startsWith($haystack, $needle){
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
  }

  /**
  * @Route("/compare")
  */
  public function compareAction(Request $request, LoggerInterface $log){
    $user = new User();
    $xsdValidator = new XSDValidator();

    if($this->isUserConnected($user, $request)){
      if($user->isAdmin()){
        if($request->get("model1") != null && $request->get("model2") != null){
          $modelTab[] = $request->get("model1");
          $modelTab[] = $request->get("model2");
          return $this->sendToCompare($xsdValidator->getComparedFile($modelTab), $user->isAdmin());
        }
        return $this->adminAction($request);
      }
    }
    return $this->sendToLogin($this->signInAsAdminMessage);
  }

  /**
  * @Route("/validator")
  */
  public function validatorAction(Request $request){
    $user = new User();

    if($this->isUserConnected($user, $request)){
      return $this->sendToValidate($user->isAdmin(), $request->get($this->xsd), $request->get($this->xml), $this->isModelValid($request));
    }

    return $this->sendToLogin($this->signInMessage);
  }

  private function actionHasBeenAskedByAdmin($request){
    $admin = new Admin();

    if($request->get($this->deleteUser) != null){
      $admin->removeUser($request->get($this->deleteUser));
      return $this->userDeleted;
    }
    elseif($request->get($this->name) != null && $request->get($this->password) != null) {
      $admin->addUser($request->get($this->name), $request->get($this->password), $this->getDoctrine()->getManager());
      return $this->userAdded;
    }
    elseif($request->get($this->modelString) != null && $request->get($this->email) != null) {
      $model = new Model();
      $model->setDescription($request->get($this->modelString));
      $admin->addModel($model, $request->get($this->email));
      return $this->modelAdded;
    }
  }

  private function setUserCookie($id){
    setcookie($this->cookieID, $id, time() + $this->hour);
  }

  private function isModelValid($request){
    $xsdValidator = new XSDValidator();
    //TODO: check if null before sending it to validator
    $xsdValidator->setXsd($request->get($this->xsd));
    $xsdValidator->setXml($request->get($this->xml));
    return $xsdValidator->isValid();
  }

  private function unsetUserCookie($id){
    setcookie($this->cookieID, $id, time() - $this->invalidateCookie);
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

  private function sendToCompare($modelCompared, $isAdmin){
    if($modelCompared == null){
      $this->adminAction(new Request());
    }
    return $this->render('view/compare.php.twig', array(
      'modelComparedString' => $modelCompared,
      'isAdmin' => $isAdmin
    ));
  }

  private function sendToValidate($isAdmin, $xsdModel, $xml, $modelValidated){
    return $this->render('view/validate.php.twig', array(
      'isAdmin' => $isAdmin,
      'modelValidated' => $modelValidated,
      'xsd' => $xsdModel,
      'xml' => $xml
    ));
  }

  private function sendToConnected($user){
    return $this->render('view/model_list.php.twig', array(
      'isAdmin' => $user->isAdmin(),
      'models' => $user->getVisibleModels()
    ));
  }

  private function sendToLogin($errorMessage){
    return $this->render('view/login.html.twig', array(
      'errorMessage' => $errorMessage
    ));
  }

  private function sendToAdmin($user, $message){
    return $this->render('view/admin.php.twig', array(
      'isAdmin' => $user->isAdmin(),
      'models' => $user->getVisibleModels(),
      'message' => $message
    ));
  }
}
