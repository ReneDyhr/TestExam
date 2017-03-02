<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

if(isset($_POST['createAccount'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];
    $surname = $_POST['surname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if(empty($username)){
        $errors[] = "Du skal udfylde et brugernavn!";
    }
    if($Account->checkUsername($username)){
        $errors[] = "Brugernavnet er allerede taget!";
    }
    if(empty($password)){
        $errors[] = "Du skal udfylde et kodeord!";
    }
    if($password!=$repeatPassword){
        $errors[] = "Dine kodeord matcher ikke!";
    }
    if(strlen($password)<6){
        $errors[] = "Dit password skal minimum indeholde 6 karakterer!";
    }
    if(empty($surname)){
        $errors[] = "Du skal udfylde et fornavn!";
    }
    if(empty($lastname)){
        $errors[] = "Du skal udfylde et efternavn!";
    }
    if(empty($email) OR !Basics::validateEmail($email)){
        $errors[] = "Du skal udfylde en email!";
    }
    if(empty($address)){
        $errors[] = "Du skal udfylde din adresse!";
    }


    if(empty($errors)){
        $Account->create($username, $password, $surname, $lastname, $address, $email);
        Alert::setAlert("success", array("Din konto er nu oprettet!"));
        header("location:/");
        exit();
    }else{
        Alert::setAlert("danger", $errors);
    }
}

include_once $_SERVER['DOCUMENT_ROOT'].'/header.php';
?>
<h1 class="title">Opret kunde</h1>
<div class="padding-left-5">
    <form method="post">
        <div class="form-group">
            <label>Brugernavn *</label>
            <input type="text" name="username" class="form-control">
        </div>
        <div class="form-group">
            <label>Kodeord *</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label>Gentag Kodeord *</label>
            <input type="password" name="repeatPassword" class="form-control">
        </div>
        <div class="form-group">
            <label>Fornavn *</label>
            <input type="text" name="surname" class="form-control">
        </div>
        <div class="form-group">
            <label>Efternavn *</label>
            <input type="text" name="lastname" class="form-control">
        </div>
        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label>Adresse *</label>
            <input type="text" name="address" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" name="createAccount" value="Opret" class="btn form-control">
        </div>
    </form>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
