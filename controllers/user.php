
<?php

class User extends SessionController{

    function __construct(){
        parent::__construct();
    }

    function render(){
        $user = $this->getUser();
        $this->view->user   = $user;
        $this->view->budget = $user['budget'];
        $this->view->name   = $user['name'];
        $this->view->photo  = $user['photo'];

        $this->view->render('dashboard/user');
    }

    // regresa una función con los datos del usuario
    function getUser(){
        $userid     = $this->getUserId();
        $username   = $this->getUsername();
        $name       = $this->model->getName($userid);
        $photo      = $this->model->getPhoto($userid);
        $budget     = $this->model->getBudget($userid);

        if($name === NULL || empty($username)) $name = $username;
        if($photo === NULL || empty($photo)) $photo = 'default.png';
        if($budget === NULL || empty($budget) || $budget < 0) $budget = 0.0;

        return Array(
            'username'  => $username,
            'name'      => $name,
            'photo'     => $photo,
            'budget'    => $budget
        );
    }

    function updateBudget(){
        if(!$this->existPOST('budget')){
            header('location: ../');
            return;
        }

        $budget = $this->getPost('budget');

        if(empty($budget) || $budget === 0 || $budget < 0){
            header('location: '. constant('URL') . 'user');
            return;
        }
    
        $this->user->setBudget($budget);
        if($this->user->update()){
        header('location: '. constant('URL') . 'user');
        }else{
            //error
        }
        //$this->model->updateBudget($budget, $this->user->getId());
        
    }

    function updateName(){
        if(!$this->existPOST('name')){
            header('location: ../');
            return;
        }

        $name = $this->getPost('name');

        if(empty($name)){
            header('location: '. constant('URL') . 'user');
            return;
        }

        $this->user->setName($name);
        if($this->user->update()){
        header('location: '. constant('URL') . 'user');
        }else{
            //error
        }
    }

    function updatePassword(){
        if(!$this->existPOST(['current_password', 'new_password'])){
        //if(!isset($_POST['current_password']) || !isset($_POST['new_password']) ){
            header('location: ../');
            return;
        }

        $current = $this->getPost('current_password');
        $new     = $this->getPost('new_password');

        if(empty($current) || empty($new)){
            header('location: '. constant('URL') . 'user');
            return;
        }

        if($current === $new){
            header('location: '. constant('URL') . 'user');
            return;
        }

        //validar que el current es el mismo que el guardado
        $newHash = $this->model->comparePasswords($current, $this->user->getId());
        if($newHash != NULL){
            //si lo es actualizar con el nuevo
            //$this->model->updatePassword($new, $id_user);
            $this->user->setPassword($new, true);
            
            if($this->user->update()){
                header('location: '. constant('URL') . 'user');
            }else{
                //error
            }
            header('location: '. constant('URL') . 'user');
        }else{
            header('location: '. constant('URL') . 'user');
            return;
        }
    }

    function updatePhoto(){
        if(!isset($_FILES['photo'])){
            header('location: ../');
            return;
        }
        $photo = $_FILES['photo'];

        $target_dir = "public/img/photos/";
        $extarr = explode('.',$photo["name"]);
        $filename = $extarr[sizeof($extarr)-2];
        $ext = $extarr[sizeof($extarr)-1];
        $hash = md5(Date('Ymdgi') . $filename) . '.' . $ext;
        $target_file = $target_dir . $hash;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        $check = getimagesize($photo["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($photo["tmp_name"], $target_file)) {
                echo "The file ". basename( $photo["name"]). " has been uploaded.";
                //$id_user = $this->getUserSession()->getUserSessionData()['id'];

                $this->model->updatePhoto($hash, $this->user->getId());
                header('location: '. constant('URL') . 'user');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        
    }
}

?>