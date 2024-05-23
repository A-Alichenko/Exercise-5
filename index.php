<?php
/**
 * Реализовать возможность входа с паролем и логином с использованием
 * сессии для изменения отправленных данных в предыдущей задаче,
 * пароль и логин генерируются автоматически при первоначальной отправке формы.
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Массив для временного хранения сообщений пользователю.
    $messages = array();
    $messages_fio = array();
    $messages_date = array();
    $messages_phone = array();
    $messages_email = array();
    $messages_biography = array();
    $messages_gender = array();
    // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
    // Выдаем сообщение об успешном сохранении.
    if (!empty($_COOKIE['save1'])||!empty($_COOKIE['save2']) ||!empty($_COOKIE['save3']) ||!empty($_COOKIE['save4'])||!empty($_COOKIE['save8'])||!empty($_COOKIE['save7']))  {
        // Удаляем куку, указывая время устаревания в прошлом.

        setcookie('save1', '', 100000);
        setcookie('save2', '', 100000);
        setcookie('save3', '', 100000);
        setcookie('save4', '', 100000);
        setcookie('save7', '', 100000);
        setcookie('save8', '', 100000);

        // Выводим сообщение пользователю.
        $messages[] = 'Спасибо, результаты сохранены.';
        // Если в куках есть пароль, то выводим сообщение.
        if (!empty($_COOKIE['pass'])) {
            $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
                strip_tags($_COOKIE['login']),
                strip_tags($_COOKIE['pass']));
        }
    }

    // Складываем признак ошибок в массив.
    $errors = array();

    $errors['name'] = !empty($_COOKIE['name_error']);
    $errors['phone'] = !empty($_COOKIE['phone_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['date'] = !empty($_COOKIE['date_error']);
    $errors['biography'] = !empty($_COOKIE['biography_error']);
    $errors['gender_error'] = !empty($_COOKIE['gender_error']);
    // TODO: аналогично все поля.

    // Выдаем сообщения об ошибках.
    if ($errors['name']) {

        setcookie('name_error', '', 100000);
        setcookie('name_value', '', 100000);

        $messages_fio[] = '<div class="error">Укажите ваше ФИО.</div>';
    }
    if ($errors['phone']) {

        setcookie('phone_error', '', 100000);
        setcookie('phone_value', '', 100000);

        $messages_phone[] = '<div class="error">Укажите корректный номер телефона.</div>';
    }
    if ($errors['email']) {

        setcookie('email_error', '', 100000);
        setcookie('email_value', '', 100000);
        // Выводим сообщение.
        $messages_email[] = '<div class="error">Введите корректный Email.</div>';
    }
    if ($errors['date']) {

        setcookie('date_error', '', 100000);
        setcookie('date_value', '', 100000);

        $messages_date[] = '<div class="error">Укажите дату рождения.</div>';
    }



    if ($errors['biography']) {

        setcookie('biography_error', '', 100000);
        setcookie('biography_value', '', 100000);

        $messages_biography[] = '<div class="error">Заполните поле биография.</div>';
    }
    if ($errors['gender']) {

        setcookie('gender_error', '', 100000);
        setcookie('gender_value', '', 100000);

        $messages_gender[] = '<div class="error">Выберете пол.</div>';
    }


    // TODO: тут выдать сообщения об ошибках в других полях.

    // Складываем предыдущие значения полей в массив, если есть.
    // При этом санитизуем все данные для безопасного отображения в браузере.
    $values = array();
    $values['name'] = empty($_COOKIE['name_value']) ? '' : strip_tags($_COOKIE['name_value']);
    $values['phone'] = empty($_COOKIE['phone_value']) ? '' : strip_tags($_COOKIE['phone_value']);
    $values['date'] = empty($_COOKIE['date_value']) ? '' : strip_tags($_COOKIE['date_value']);
    $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
    $values['biography'] = empty($_COOKIE['biography_value']) ? '' : strip_tags($_COOKIE['biography_value']);
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : strip_tags($_COOKIE['gender_value']);
    // TODO: аналогично все поля.

    // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
    // ранее в сессию записан факт успешного логина.
    if (!empty($_COOKIE[session_name()]) &&
        session_start() && !empty($_SESSION['auth'])) {

        $values['name'] = empty($_COOKIE['name_value']) ? '' : strip_tags($_SESSION['auth']['name']);
        $values['phone'] = empty($_COOKIE['phone_value']) ? '' : strip_tags($_SESSION['auth']['phone']);
        $values['date'] = empty($_COOKIE['date_value']) ? '' : strip_tags($_SESSION['auth']['date']);
        $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_SESSION['auth']['email']);
        $values['biography'] = empty($_COOKIE['biography_value']) ? '' : strip_tags($_SESSION['auth']['biography']);
        $values['gender'] = empty($_COOKIE['gender_value']) ? '' : strip_tags($_SESSION['auth']['gender']);


        // TODO: загрузить данные пользователя из БД
        // и заполнить переменную $values,
        // предварительно санитизовав.
        printf('Вход с логином %s, uid %d', $_SESSION['auth']['login'], $_SESSION['auth']['uid']);

    }

    // Включаем содержимое файла form.php.
    // В нем будут доступны переменные $messages, $errors и $values для вывода
    // сообщений, полей с ранее заполненными данными и признаками ошибок.
    include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
    // Проверяем ошибки.
    $errors = FALSE;
    if (empty($_POST['name'])) {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['phone']) || !preg_match('~^(?:\+7|8)\d{10}$~', $_POST['phone']) ) {

        setcookie('phone_error', '2', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);
    }


    if (empty($_POST['email']) || preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $_POST['phone'])) {

        setcookie('email_error', '3', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
    }
    if (empty($_POST['date'])) {

        setcookie('date_error', '4', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);
    }


    if (empty($_POST['biography'])|| preg_match('/^[a-zA-Zа-яА-Яе0-9,.!? ]+$/',$_POST['biography'])) {

        setcookie('biography_error', '7', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
    }
    if (empty($_POST['gender'])) {

        setcookie('gender_error', '8', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
    }
// *************
// TODO: тут необходимо проверить правильность заполнения всех остальных полей.
// Сохранить в Cookie признаки ошибок и значения полей.
// *************

    if ($errors) {
        // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
        header('Location: index.php');
        exit();
    }
    else {
        // Удаляем Cookies с признаками ошибок.
        setcookie('name_error', '', 100000);
        setcookie('phone_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('date_error', '', 100000);
        setcookie('biography_error', '', 100000);
        setcookie('gender_error', '', 100000);

        // TODO: тут необходимо удалить остальные Cookies.
    }

    // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
    if (!empty(session_name()) && session_start() && $_SESSION['auth']) {

    }
    else {
        // Генерируем уникальный логин и пароль.
        // TODO: сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
        function gen_login(int $length)
        {
            $password = '';
            $arr = array(
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
                'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
                'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
            );

            for ($i = 0; $i < $length; $i++) {
                $password = $arr[random_int(0, count($arr) - 1)];
            }
            return $password;
        }
        // Генерируем уникальный логин и пароль.
        // TODO: сделать механизм генерации, например функциями rand(), uniquid(), md5(), substr().
        $login = gen_login(6);
        $password = gen_login(10);
        // Сохраняем в Cookies.
        setcookie('login', $login);
        setcookie('pass', $password);
        // TODO: Сохранение данных формы, логина и хеш md5() пароля в базу данных.
        // ...
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $date = $_POST['date'];
        $gender = $_POST['gender'];
        $biography = $_POST['biography'];
        $agree = $_POST['agree'];

    }
    $user = 'u67364';
    $pass = '9539974';

    $db = new PDO('mysql:host=localhost;dbname=u67364', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    foreach ($_POST['languages[]'] as $language) {
        $stmt = $db->prepare("SELECT id FROM languages WHERE id= :id");
        $stmt->bindParam(':id', $language);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            print('Ошибка при добавлении языка.<br/>');
            exit();
        }
    }

    try {
        $stmt = $db->prepare("INSERT INTO application (names,phones,email,dates,gender,biography,password,login)" . "VALUES (:name,:phone,:email,:date,:gender,:biography, :password, :login)");
        $stmt->execute(array('name' => $name, 'phone' => $phone, 'email' => $email, 'date' => $date, 'gender' => $gender, 'biography' => $biography, 'password' => md5($password), 'login' => $login));
        $applicationId = $db->lastInsertId();

        foreach ($_POST['languages[]'] as $language) {
            $stmt = $db->prepare("SELECT id FROM languages WHERE title = :title");
            $stmt->bindParam(':title', $language);
            $stmt->execute();
            $languageRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($languageRow) {
                $languageId = $languageRow['id'];

                $stmt = $db->prepare("INSERT INTO application_lang (id_lang, id_app) VALUES (:languageId, :applicationId)");
                $stmt->bindParam(':languageId', $languageId);
                $stmt->bindParam(':applicationId', $applicationId);
                $stmt->execute();
            } else {
                print('Ошибка: Не удалось найти ID для языка программирования: ' . $language . '<br/>');
                exit();
            }
        }



    }
    catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    }


    // Сохраняем куку с признаком успешного сохранения.

    setcookie('save1', '1');
    setcookie('save2', '2');
    setcookie('save3', '3');
    setcookie('save4', '4');
    setcookie('save7', '7');
    setcookie('save8', '8');
    //setcookie('save_pass', '8');
    // setcookie('save_login', '9');

    // Делаем перенаправление.
    header('Location: ./');
}