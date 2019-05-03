<!-- Created by Wojciech Augustyn -->
<?php
//Filters user data
$imie = htmlspecialchars(trim($_POST['imie']));
$mail = htmlspecialchars(trim($_POST['mail']));
$temat =  htmlspecialchars(trim($_POST['temat']));
$wiadomosc = htmlspecialchars(trim($_POST['wiadomosc']));
$send = $_POST['send'];
//Mail to which messages will be sent
$odbiorca = "wojciech.augustyn85@gmail.com";
//Headlines
$header = "Content-type: text/html; charset=utf-8\r\nFrom: $mail";

//Headers I check if there is a cookie if I display the message
if (isset($_COOKIE['send'])) $error ='Wait '.($_COOKIE['send']-time()).' seconds before sending the next message</br>';   

if ($send && !isset($_COOKIE['send']))
    {
    //I'm checking the nickname
    if (empty($imie))
        { $error = "You have not filled the field <strong>Nick !</strong><br/>"; }
    elseif (strlen($imie) > 20)
        { $error .="For a long nickname - max. 20 characters <br/>";}
     
    //I check the email
    if (empty($mail))
        { $error .= "You have not filled the field <strong>E-mail !</strong><br/>"; }
    elseif (strlen($mail) > 30)
        { $error .="For long e-mail - max. 30 characters <br/>";}
    elseif (preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9\-\_\.]+\@[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9\-\_\.]+\.[a-z]{2,4}$/',$mail) == false)
        { $error .= "Incorrect email address! <br/>"; }
         
    //I'm checking the topic
    if (empty($temat))
        { $error .= "You have not filled the field <strong>Topic !</strong><br/>"; }
    elseif (strlen($temat) > 120)
        { $error .="For a long topic - max. 120 characters <br/>";}
         
    //I check the message
    if (empty($wiadomosc))
        { $error .= "You have not filled the field <strong>Message !</strong><br/>"; }
    elseif (strlen($wiadomosc) > 400)
        { $error .="For a long message - max. 400 characters <br/>";}

    //I check for errors and send a message
    if (empty($error))
        {
        $list = "Sender - $imie ($mail) <br/> Message content - $wiadomosc";
         
        if (mail($odbiorca, $temat, $list, $header))   
        {
         $error .= "Your message has been sent <br/>";
         setcookie("send", time()+60, time()+60);
         }
        else
            { $error .= "An error occurred while sending a message, please try again later. </br>";}   
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Web Developer Wojciech Augustyn</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Oswald:400,700&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon-196x196.png">
    <link rel="apple-touch-icon" href="img/favicon-196x196.png">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <br id="contact">
    <form action="" method="post">
        <fieldset>
            <legend>Contact form</legend>
            <!-- Statement -->
            <div style="text-align: center;">
                <a href="#imie" style="font-family: 'Oswald', sans-serif; font-size: 15px; text-decoration: none; color: lightgreen"><?php echo $error; ?></a>
            </div>
            <p1> <input type="text" required id="imie" name="imie" placeholder="Name/nickname" /><br></p1>
            <p2><input type="text" required id="mail" name="mail" placeholder="Your e-mail" /><br></p2>
            <p3><input type="text" required id="temat" name="temat" placeholder="Topic" /><br></p3>
            <p4>
                <label for="wiadomosc">Message:</label><br>
                <textarea id="wiadomosc" required name="wiadomosc" cols="40" rows="10"></textarea>
            </p4><br>
            <input type="submit" value="SEND" id="send" name="send" />
        </fieldset>
    </form>
</body>

</html>
