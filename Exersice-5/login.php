<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
$session_started = false;
if ($_COOKIE[session_name()] && session_start()) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
    // Если есть логин в сессии, то пользователь уже авторизован.
    // TODO: Сделать выход (окончание сессии вызовом session_destroy()
    //при нажатии на кнопку Выход).
    // Делаем перенаправление на форму.
    header('Location: form.php');
    exit();
  }
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
    <style>
    body {

    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 50px;
    background-color: #18191C;
    color: #FFFFFF;
    font-size: 18px;
    font-family: "Roboto", sans-serif;
    }
    form:valid {
        border-color: #FFFFFF;
    }

    .form-row {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    form {
    border: 1px solid;
    padding: 55px 80px;
    }
    .button-blue {
        background-color: #2E9AFF;
    }
    fieldset:invalid {
        border-color: #FF8630;
    }
    .input {
        border: 1px solid #ffffff;
        border-radius: 6px;
        padding: 10px 15px;
        background-color: transparent;
        color: #ffffff;
        font-family: inherit;
        font-size: inherit;
        font-weight: 300;
        -webkit-appearance: none;
        appearance: none;
    }
    .button {
        display: block;
        min-width: 210px;
        border: 2px solid transparent;
        border-radius: 6px;
        padding: 9px 15px;
        color: #000000;
        font-size: 18px;
        font-weight: 300;
        font-family: inherit;
        transition: background-color 0.2s linear;
    }
    .input, .button, .checkbox-container {
        width: 350px;
    }
    .input-title {
        margin-right: 35px;
        font-size: 24px;
        font-weight: 500;
        line-height: 1;
    }
    .form-row + .form-row {
        margin-top: 25px;
    }
    .button, .checkbox-container {
        margin-left: auto;
    }
    .input:invalid {
        border-color: #FF8630;
        background-color: rgba(255, 134, 48, 0.1);
    }
    </style>
<form action="" method="post">
    <fieldset>
        <legend>
            Персональные данные
        </legend>
        <div class="form-row">
            <label class="input-title" for="login">Логин:</label>
            <input class="input" type="text" name="login" id="login">
            <span></span>
        </div>
        <div class="form-row">
            <label class="input-title" for="pass">Пароль:</label>
            <input class="input" type="text" name="pass" id="pass">
            <span></span>
        </div>
    </fieldset>
    <div class="form-row">
          <button class="button button-blue" type="submit">Войти</button>
    </div>
    <!--<input name="login" />
  <input name="pass" />
  <input type="submit" value="Войти" />-->
</form>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.

  if (!$session_started) {
    session_start();
  }
  // Если все ок, то авторизуем пользователя.
  $_SESSION['login'] = $_POST['login'];
  // Записываем ID пользователя.
  $_SESSION['uid'] = 123;

  // Делаем перенаправление.
  header('Location: ./');
}
