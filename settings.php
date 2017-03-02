<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

if(!$loggedIn){
    header("location:/");
    exit();
}

if(isset($_POST['editAccount'])){
    $surname = $_POST['surname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $address = $_POST['address'];


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
        $Account->edit($user_id, $surname, $lastname, $address, $email);
        Alert::setAlert("success", array("Din konto er nu opdateret!"));
        header("location:/");
        exit();
    }else{
        Alert::setAlert("danger", $errors);
    }
}

include_once $_SERVER['DOCUMENT_ROOT'].'/header.php';

?>
<h1 class="title">Indstillinger</h1>
<div class="padding-left-5">
    <form method="post">
        <div class="form-group">
            <label>Fornavn</label>
            <input type="text" value="<?php echo $AccountInfo->surname;?>" name="surname" class="form-control">
        </div>
        <div class="form-group">
            <label>Efternavn</label>
            <input type="text" value="<?php echo $AccountInfo->lastname;?>" name="lastname" class="form-control">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" value="<?php echo $AccountInfo->email;?>" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label>Adresse</label>
            <input type="text" name="address" value="<?php echo $AccountInfo->address;?>" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" name="editAccount" value="Rediger" class="btn form-control">
        </div>
    </form>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
