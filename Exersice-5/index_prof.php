<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM
header('Content-Type: text/html; charset=UTF-8');

if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['auth'])) {

    $values['name_prf'] = strip_tags($_SESSION['auth']['name']);
    $values['phone_prf'] = strip_tags($_SESSION['auth']['phone']);
    $values['date_prf'] = strip_tags($_SESSION['auth']['date']);
    $values['email_prf'] = strip_tags($_SESSION['auth']['email']);
    $values['biography_prf'] = strip_tags($_SESSION['auth']['biography']);
    $values['gender_prf'] = strip_tags($_SESSION['auth']['gender']);
    printf('Вход с логином %s, uid %d', $_SESSION['auth']['login'], $_SESSION['auth']['uid']);
}
include('profile.php');
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
if (isset($_POST['save'])) {



    $name_auth = $_POST['name'];
    $phone_auth = $_POST['phone'];
    $email_auth = $_POST['email'];
    $date_auth = $_POST['date'];
    $biography_auth = $_POST['biography'];
    $gender_auth = $_POST['gender'];
    $uid = $_SESSION['auth']['uid'];

    $db = new PDO('mysql:host=localhost;dbname=u67364', 'u67364', '9539974', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    try {
        $stmt = $db->prepare("UPDATE application SET names = ?, phones = ?, email = ?, dates = ?, gender = ?, biography = ? WHERE id = ?");
        $stmt->bindParam(1, $name_auth, PDO::PARAM_STR);
        $stmt->bindParam(2, $phone_auth, PDO::PARAM_STR);
        $stmt->bindParam(3, $email_auth, PDO::PARAM_STR);
        $stmt->bindParam(4, $date_auth, PDO::PARAM_STR);
        $stmt->bindParam(5, $gender_auth, PDO::PARAM_STR);
        $stmt->bindParam(6, $biography_auth, PDO::PARAM_STR);
        $stmt->bindParam(7, $uid, PDO::PARAM_INT);
        $stmt->execute();

         // Исправлено использование printf для вывода сообщения

        printf('Данные обновлены!');
    } catch (PDOException $e) {
        // Обработка ошибки
        echo "Ошибка при обновлении данных: " . $e->getMessage();
    }
}
?>
