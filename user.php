<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
$error = [];
    if (!empty($_POST)) {
        if (empty($_POST['name'])) {
            $error['name'] = 'Имя не может пустым';
        }
        if (empty($_POST['surname'])) {
            $error['surname'] = 'Фамилия не может пустой';
        }
        if (empty($_POST['age']) || $_POST['age'] < 1) {
            $error['age'] = 'Возраст задан некорректно';
        }
    }
    $lang = (!empty($_GET['lang'])) ? $_GET['lang'] : 'ru';
    $labels = [
            'ru' => ['name' => 'Имя', 'surname' => 'Фамилия', 'age' => 'Возраст', 'gender' => 'Пол'],
            'ua' => ['name' => "Им'я", 'surname' => 'Прізвище', 'age' => 'Вік', 'gender' => 'Стать'],
            'en' => ['name' => 'Name', 'surname' => 'Surname', 'age' => 'Age', 'gender' => 'Gender'],
    ];

    switch ($lang) {
        case 'ru':
            $translation = $labels['ru'];
            break;
        case 'ua':
            $translation = $labels['ua'];
            break;
        case 'en':
            $translation = $labels['en'];
            break;

    }

    // array_column
    // array_search
    // min
// max
// sort

//   $ages = array_column($users, 'age');
//   $key = array_search(65, $ages);
//
////   if ($key != false) {
////       echo "The Age found";
////   } else {
////       echo "NOT FOUND";
////   }
//   var_dump($ages);
//   echo "<br />";
//   rsort($ages);
//   var_dump($ages);
//   echo "<br />";
//   var_dump(max($ages));
//   exit();

?>
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
        <a href="?lang=ru" class="badge badge-primary">Русский</a>
        <a href="?lang=ua" class="badge badge-secondary">Украинский</a>
        <a href="?lang=en" class="badge badge-success">Английский</a>
    </div>
    <form method="post" action="stats.php">
        <div class="form-group">
            <label for="formGroupExampleInput"><?=$translation['name'] ?></label>
            <input type="text" class="form-control" id="formGroupExampleInput" name="name" placeholder="Example input"
                   value="<?php echo $_POST['name'] ?? 'Mike' ?>">
            <?php if (!empty($error['name'])) : ?>
            <small id="passwordHelpBlock" class="form-text text-muted">
                <?=$error['name'] ?>
            </small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput"><?=$translation['surname'] ?></label>
            <input type="text" class="form-control" id="formGroupExampleInput" name="surname"
                   placeholder="Example input" value="<?= $_POST['surname'] ?? 'Kardakov' ?>">
            <?php if (!empty($error['surname'])) : ?>
                <small id="passwordHelpBlock" class="form-text text-muted">
                    <?=$error['surname'] ?>
                </small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput"><?=$translation['age'] ?></label>
            <input type="number" class="form-control" id="formGroupExampleInput" name="age" placeholder="Example input"
                   value="<?= $_POST['age'] ?? '20' ?>">
            <?php if (!empty($error['age'])) : ?>
                <small id="passwordHelpBlock" class="form-text text-muted">
                    <?=$error['age'] ?>
                </small>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Почта</label>
            <input type="email" class="form-control" id="formGroupExampleInput" name="email" placeholder="Example input"
                   value="<?= $_POST['email'] ?? 'example@gmail.com' ?>">
        </div>
        <div class="form-group">
            <?php $gender = empty($_POST['gender']) ? 'Others' : $_POST['gender']; ?>
            <label for="exampleFormControlSelect1"><?=$translation['gender'] ?></label>
            <select class="form-control" id="exampleFormControlSelect1" name="gender">
                <option></option>
                <option <?=$gender == 'Man' ? 'selected': '' ?>>Man</option>
                <option <?=$gender == 'Woman' ? 'selected': '' ?>>Woman</option>
                <option <?=$gender == 'Others' ? 'selected': '' ?>>Others</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>
</body>
</html>
