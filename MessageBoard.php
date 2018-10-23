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
    //Find out if got here with data
    if (isset($_GET['action'])) {
        if (file_exists("messages.txt") && filesize("messages.txt") != 0) {
        //Error if there are no messages
            $messageArray = file("messages.txt");
            switch ($_GET['action']) {
                case 'Delete First':
                    //Dump first element and shrink
                    array_shift($messageArray);
                    break;
                case 'Delete Last':
                    array_pop($messageArray);
                    break;
                 case 'Delete Message':
                    array_splice($messageArray, $_GET['message'],1);
                    //$index = $_GET['message'];
                    //unset($messageArray[$index]);
                    //array_values($messageArray);
                    break;
                    
            }
            if (count($messageArray) > 0) {
                //implode message array
                $newMessages = implode($messageArray);
                //opens the file in write binary mode
                $fileHandle = fopen("messages.txt", "wb");
                if (!$fileHandle) {
                    //If not get a file handle echos a message
                    echo "There was an error updating the message file.\n";
                }
                else {
                    fwrite($fileHandle, $newMessages);
                    //Success, if gets file handle
                    fclose($fileHandle);
                }
            }
            else {
                unlink("messages.txt");
            }
       }
    }
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
            echo "<td width=\"85%\"><span style=\"font-weight: bold\">Subject: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            echo "<span style=\"font-weight: bold\">Name: </span>" . htmlentities($currMsg[1]) . "<br>\n";
            echo "<span style=\"text-decoration: underline; font-weight: bold\">Messages: </span>" . htmlentities($currMsg[2]) . "<td>\n";
            echo "<td width=\"10%\" style=\"text-align: center\">" . "<a href='MessageBoard.php?" . "action=Delete%20Message&" . "message=$i'>" . "Delete This Message</a></td>\n";
            echo "</tr>\n";
        }
        echo "</table>";
    }
    ?>
        <p>
            <a href="PostMessage.php">Post New Message</a>
            <br>
            <!-- ? is a query string -->
            <a href="MessageBoard.php?action=Delete%20First">Delete First Message</a><br>
            <a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a>
            <br>
        </p>
</body>

</html>
