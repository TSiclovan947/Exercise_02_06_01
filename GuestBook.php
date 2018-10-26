<!doctype html>

<html>

<head>
    <!--   
         Exercise 02_06_01
         Author: Tabitha Siclovan
         Date: October 24, 2018
        
         GuestBook.php
    -->
    <title>GuestBook</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body style="background-color: rgb(208, 248, 255)">
    <h1 style="text-align: center">GuestBook Sign-In</h1>
    <?php
    //Find out if got here with data
    if (isset($_GET['action'])) {
        if (file_exists("Guests.txt") && filesize("Guests.txt") != 0) {
        //Error if there are no messages
            $messageArray = file("Guests.txt");
            switch ($_GET['action']) {
                case 'Delete First':
                    //Dump first element and shrink
                    array_shift($messageArray);
                    break;
                case 'Delete Last':
                    array_pop($messageArray);
                    break;
                case 'Sort Ascending':
                    sort($messageArray);
                    break;
                case 'Sort Descending':
                    rsort($messageArray);
                    break;
                 case 'Delete Message':
                    array_splice($messageArray, $_GET['email'], 1);
                    break;
                    case 'Remove Duplicates':
                    $messageArray = array_unique($messageArray);
                    //Re-number index
                    $messageArray = array_values($messageArray);
                    break;
                    
            }
            if (count($messageArray) > 0) {
                //implode message array
                $newMessages = implode($messageArray);
                //opens the file in write binary mode
                $fileHandle = fopen("Guests.txt", "wb");
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
                unlink("Guests.txt");
            }
       }
    }
    if (!file_exists("Guests.txt") || filesize("Guests.txt") == 0) {
        //Error if there are no messages
        echo "<p>There are no guest user sign-ins</p>\n";
    }
    else {
        $messageArray = file("Guests.txt");
        //Table created with built-in styles
        echo "<table style=\"background-color: rgb(131, 229, 255)\" border=\"1\" width=\"100%\">\n";
        $count = count($messageArray);
        for ($i = 0; $i < $count; $i++) {
            $currMsg = explode("~", $messageArray[$i]);
            $keyMessageArray[$currMsg[0]] = $currMsg[1] . "~" . $currMsg[2];
        }
         //Take place of $i
        $index = 1;
        $key = key($keyMessageArray);
        foreach ($keyMessageArray as $message) {
            //Explodes the message array
            $currMsg = explode("~", $message);
            echo "<tr>\n";
            //Table data with styles
            echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold\">" . $index . "</td>\n";
            echo "<td width=\"85%\"><span style=\"font-weight: bold\">First Name: </span>" . htmlentities($key) . "<br>\n";
            echo "<span style=\"font-weight: bold\">Last Name: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            echo "<span style=\"text-decoration: underline; font-weight: bold\">Email Address: </span>" . htmlentities($currMsg[1]) . "<td>\n";
            echo "<td width=\"10%\" style=\"text-align: center\">" . "<a href='GuestBook.php?" . "action=Delete%20Message&" . "guest=" . ($index - 1) . "'>" . "Delete This Guest</a></td>\n";
            echo "</tr>\n";
            ++$index;
            next($keyMessageArray);
            $key = key($keyMessageArray);
        }
        echo "</table>";
    }
    ?>
        <p> 
            <!-- Hyperlink to form to post messages -->
            <a href="PostGuest.php">Sign In Another User</a>
            <br>
            <!-- ? is a query string -->
            <!-- Hyperlink to delete first message in array -->
            <a href="GuestBook.php?action=Sort%20Ascending">Sort Names A-Z</a><br>
            <a href="GuestBook.php?action=Sort%20Descending">Sort Names Z-A</a><br>
            <a href="GuestBook.php?action=Delete%20First">Delete First Guest</a><br>
            <!-- Hyperlink to delete last message in array -->
            <a href="GuestBook.php?action=Delete%20Last">Delete Last Guest</a><br>
            <!-- Hyperlink to remove message duplicates -->
            <!--<a href="MessageBoard.php?action=Remove%20Duplicates">Remove Duplicates</a>-->
            <br>
        </p>
</body>

</html>
