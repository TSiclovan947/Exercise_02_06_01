<!doctype html>

<html>

<head>
    <!--   
         Exercise 02_06_01
         Author: Tabitha Siclovan
         Date: October 19, 2018
        
         MessageBoard.php
    -->
    <title>Message Board</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h1>Message Board</h1>
    <?php
    if (!file_exists("messages.txt") || filesize("messages.txt") == 0) {
        //Error if there are no messages
        echo "<p>There are no messages posted</p>\n";
    }
    else {
        $messageArray = file("messages.txt");
        //Table created with built-in styles
        echo "<table style=\"background-color: lightgray\" border=\"1\" width=\"100%\">\n";
        $count = count($messageArray);
        for ($i = 0; $i < $count; $i++) {
            //Explodes the message array
            $currMsg = explode("~", $messageArray[$i]);
            echo "<tr>\n";
            //Table data with styles
            echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold\">" . ($i + 1) . "</td>\n";
            echo "<td width=\"95%\"><span style=\"font-weight: bold\">Subject: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            echo "</tr>\n";
        }
        echo "</table>";
    }
    ?>
</body>

</html>
