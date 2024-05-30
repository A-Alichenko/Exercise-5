<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации Аличенко Александра</title>
    <style>
        /* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
        .error {
            border: 2px solid red;
            border-radius: 4px;
        }
        .text{color: #FFFFFF;}

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 50px;
            background-color: #18191C;
            margin-left: auto;
            margin-right: auto;
            font-size: 30px;
            font-family: "Roboto", sans-serif;
            color: #FFFFFF;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #1b1818;

            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #FFFFFF;

        }
        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #000000;
            border-radius: 4px;
            box-sizing: border-box;

        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;

        }
        .title, .btn {
            display: block;
            margin: 10px 0 0 0;

        }
        img {
            width: 100%;

        }
    </style>
</head>
<body>

<div class="body">


    <?php
    if (!empty($messages)&& session_start()&& !empty(session_name())) {
        print('<div id="messages">');
        // Выводим все сообщения.
        foreach ($messages as $message) {
            print($message);
        }
        print('</div>');
    }
    ?>
</div>



<div class="container">
    <h2>Профиль</h2>
    <form action="index_prof.php" method="post">


        <label for="name">ФИО:</label><br>
        <input type="text" id="name" name="name" <?php  ?> value="<?php  print $values['name_prf']; ?>"
        /> <br>

        <label for="phone">Телефон:</label><br>
        <input type="tel" id="phone" name="phone"  value="<?php  print $values['phone_prf'];?>" /> <br>

        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email"  value="<?php  print $values['email_prf']; ?>"/><br>

        <label for="dob">Дата рождения:</label><br>
        <input type="date" id="dob" name="date" value="<?php print $values['date_prf'];?>"/><br>

        <label>Пол:</label><br>
        <input type="radio" id="male" name="gender" value="m" <?php if ($errors['gender']) {print 'class="error"';} ?><?php if( $values['gender_prf'] == 'm'){?> checked = "<?php {$values['gender_prf'] = 'on';}}?>"> <?php
        if (!empty($messages_gender)) {
            print('<div id="messages">');
            // Выводим все сообщения.
            foreach ($messages_gender as $message_gender) {
                print($message_gender);
            }
            print('</div>');
        }
        ?>
        <label for="male">Мужской</label>
        <input type="radio" id="female" name="gender" value="f" <?php if ($errors['gender']) {print 'class="error"';} ?><?php if( $values['gender_prf'] == 'f'){?> checked = "<?php {$values['gender_prf'] = 'on';}}?>"> <?php
        if (!empty($messages_gender)) {
            print('<div id="messages">');
            // Выводим все сообщения.
            foreach ($messages_gender as $message_gender) {
                print($message_gender);
            }
            print('</div>');
        }
        ?>
        <label for="female">Женский</label><br>
        <input class="btn" type="submit" name = "save" value="Сохранить">
        <input type="submit" name="logout" value="Выйти">
        <label class="title" for="biography">Биография:</label>
        <textarea id="biography" name="biography" rows="4"> <?php print $values['biography_prf'];?></textarea><br>



    </form>

</div>

</body>
</html>