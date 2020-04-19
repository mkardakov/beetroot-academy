<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<br/>
<h1>Форма регистрации</h1>
<div class="container">
    <div class="float-right">
        <a href="#" class="badge badge-primary">Русский</a>
        <a href="#" class="badge badge-secondary">Украинский</a>
        <a href="#" class="badge badge-success">Английский</a>
    </div>
    <form method="post" action="user.php">
        <div class="form-group">
            <label for="formGroupExampleInput">Имя</label>
            <input type="text" class="form-control" id="formGroupExampleInput" name="name" placeholder="Example input"
                   value="<?php echo $_POST['name'] ?? 'Mike' ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Фамилия</label>
            <input type="text" class="form-control" id="formGroupExampleInput" name="surname"
                   placeholder="Example input" value="<?= $_POST['surname'] ?? 'Kardakov' ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Возраст</label>
            <input type="number" class="form-control" id="formGroupExampleInput" name="age" placeholder="Example input"
                   value="<?= $_POST['age'] ?? '20' ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Почта</label>
            <input type="email" class="form-control" id="formGroupExampleInput" name="email" placeholder="Example input"
                   value="<?= $_POST['email'] ?? 'example@gmail.com' ?>">
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Example select</label>
            <select multiple="multiple" class="form-control" id="exampleFormControlSelect1" name="gender[]">
                <option>Man</option>
                <option>Woman</option>
                <option>Others</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>
</body>
</html>
