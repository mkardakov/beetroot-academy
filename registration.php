<?php
$name = 'Petya';
$surname = 'Petrov';
$age = '25';
$mail = 'petya@mail.com';
var_dump($_POST);
var_dump($_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<br />
<h1>Your Name <?=$_POST['name']?> and your gender <?=$_POST['gender'][0] ?></h1>
<div class="container">
    <form method="post" action="user.php">
        <div class="form-group">
            <label for="formGroupExampleInput">Name</label>
            <input type="text" class="form-control" id="formGroupExampleInput" name="name" placeholder="Example input" value="<?php echo $_POST['name'] ?? 'Vasya'?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Surname</label>
            <input type="text" class="form-control" id="formGroupExampleInput" name="surname" placeholder="Example input" value="<?=$_POST['surname'] ?? 'Petrov'?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Age</label>
            <input type="text" class="form-control" id="formGroupExampleInput" name="age" placeholder="Example input" value="<?php echo $_POST['age'] ?? '25'?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Mail</label>
            <input type="text" class="form-control" id="formGroupExampleInput" name="mail" placeholder="Example input" value="<?php echo $_POST['mail'] ?? 'petya@mail.com'?>">
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Example select</label>
            <select multiple class="form-control" id="exampleFormControlSelect1" name="gender[]">
                <option>Man</option>
                <option>Women</option>
                <option>None</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
