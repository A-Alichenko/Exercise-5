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
    <?php session_destroy() ;
    if (!empty($messages)) {
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
    <h2>Регистрационная форма</h2>
    <form action="index.php" method="post">


        <label for="name">ФИО:</label><br>
        <input type="text" id="name" name="name" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php  print $values['name']; ?>"
        /> <?php if (!empty($messages_fio)) {
            print('<div id="messages_fio">');
            // Выводим все сообщения.
            foreach ($messages_fio as $message_fio) {
                print($message_fio);
            }

        }?><br>

        <label for="phone">Телефон:</label><br>
        <input type="tel" id="phone" name="phone"  <?php if ($errors['phone']) {print 'class="error"';} ?> value="<?php  print $values['phone'];?>" /><?php if (!empty($messages_phone)) {
            print('<div id="messages">');
            // Выводим все сообщения.
            foreach ($messages_phone as $message_phone) {
                print($message_phone);
            }
        }?> <br>

        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email" <?php if ($errors['email']) {print 'class="error"';}?>  value="<?php  print $values['email']; ?>"/><?php if (!empty($messages_email)) {
            print('<div id="messages">');
            // Выводим все сообщения.
            foreach ($messages_email as $message_email) {
                print($message_email);
            }
        }?> <br>

        <label for="dob">Дата рождения:</label><br>
        <input type="date" id="dob" name="date" <?php if ($errors['date']) {print 'class="error"';} ?> value="<?php print $values['date'];?>"/><?php if (!empty($messages_date)) {
            print('<div id="messages">');
            // Выводим все сообщения.
            foreach ($messages_date as $message_date) {
                print($message_date);
            }
        }?><br>

        <label>Пол:</label><br>
        <input type="radio" id="male" name="gender" value="m" <?php if ($errors['gender']) {print 'class="error"';} ?><?php if( $values['gender'] == 'm'){?> checked = "<?php {$values['gender'] = 'on';}}?>"> <?php
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
        <input type="radio" id="female" name="gender" value="f" <?php if ($errors['gender']) {print 'class="error"';} ?><?php if( $values['gender'] == 'f'){?> checked = "<?php {$values['gender'] = 'on';}}?>"> <?php
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


        <label class="title" for="prog_lang">Любимый язык программирования:</label>

        <!-- <select id="prog_lang" name="prog_lang[]" multiple required> -->
        <select id="prog_lang"  name="Languages[]" multiple="multiple" required>
            <option value="Pascal">Pascal</option>
            <option value="C">C</option>
            <option value="C++">C++</option>
            <option value="JavaScript">JavaScript</option>
            <option value="PHP">PHP</option>
            <option value="Python">Python</option>
            <option value="Java">Java</option>
            <option value="Haskel">Haskel</option>
            <option value="Clojure">Clojure</option>
            <option value="Prolog">Prolog</option>
            <option value="Scala">Scala</option>
        </select><br>

            <label class="title" for="biography">Биография:</label>
            <textarea id="biography" name="biography" rows="4" <?php if($errors['biography']){print 'class="error"';}?>><?php print $values['biography'];?></textarea><?php if (!empty($messages_biography)){
                print('<div id="messages">');
                // Выводим все сообщения.
                foreach ($messages_biography as $message_biography) {
                 print($message_biography);
                }
             print('</div>');}?><br>





            <input type="checkbox" id="contract" name="agree" required>
            <label for="contract">С контрактом ознакомлен(а)</label><br>
            <input class="btn" type="submit" value="Сохранить">
        </form>
    </div>

    </body>
</html>