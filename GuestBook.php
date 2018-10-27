<!doctype html>

<html>

<head>
    <!--   
         Exercise 02_06_01
         Author: Tabitha Siclovan
         Date: October 19, 2018
        
         GuestBook.php
    -->
    <title>Guest Book</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body style="background-color: rgb(208, 248, 255)">
   <h1 style="text-align: center">GuestBook Sign-In Information</h1>
    <?php
    //Find out if got here with data
    if (isset($_GET['action'])) {
        if (file_exists("Guests.txt") && filesize("Guests.txt") != 0) {
        //Error if there are no messages
            $guestArray = file("Guests.txt");
            switch ($_GET['action']) {
                case 'Delete First':
                    //Dump first element and shrink
                    array_shift($guestArray);
                    break;
                case 'Delete Last':
                    array_pop($guestArray);
                    break;
                case 'Sort Ascending':
                    sort($guestArray);
                    break;
                case 'Sort Descending':
                    rsort($guestArray);
                    break;
                case 'Delete Message':
                    array_splice($guestArray, $_GET['message'], 1);
                    break;
                case 'Remove Duplicates':
                    $guestArray = array_unique($guestArray);
                    //Re-number index
                    $guestArray = array_values($guestArray);
                    break;
                    
            }
            if (count($guestArray) > 0) {
                //implode message array
                $newGuest = implode($guestArray);
                //opens the file in write binary mode
                $fileHandle = fopen("Guests.txt", "wb");
                if (!$fileHandle) {
                    //If not get a file handle echos a message
                    echo "There was an error updating the guest sign-in file.\n";
                }
                else {
                    fwrite($fileHandle, $newGuest);
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
        echo "<p>There are no messages posted</p>\n";
    }
    else {
        $guestArray = file("Guests.txt");
        //Table created with built-in styles
        echo "<table style=\"background-color: rgb(131, 229, 255)\" border=\"1\" width=\"100%\">\n";
        $count = count($guestArray);
        for ($i = 0; $i < $count; $i++) {
            $currMsg = explode("~", $guestArray[$i]);
            $keyGuestArray[$currMsg[0]] = $currMsg[1] . "~" . $currMsg[2];
        }
        //Take place of $i
        $index = 1;
        $key = key($keyGuestArray);
        foreach ($keyGuestArray as $message) {
            //Explodes the message array
            $currMsg = explode("~", $message);
            echo "<tr>\n";
            //Table data with styles
            echo "<td width=\"15%\" style=\"text-align: center; font-weight: bold\">" . $index . "</td>\n";
            echo "<td width=\"70%\"><span style=\"font-weight: bold\">First Name: </span>" . htmlentities($key) . "<br>\n";
            echo "<span style=\"font-weight: bold\">Last Name: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            echo "<span style=\"text-decoration: underline; font-weight: bold\">Email: </span>" . htmlentities($currMsg[1]) . "<td>\n";
            echo "<td width=\"15%\" style=\"text-align: center\">" . "<a href='GuestBook.php?" . "action=Delete%20Message&" . "message=" . ($index - 1) . "'>" . "Delete This Guest</a></td>\n";
            echo "</tr>\n";
            ++$index;
            next($keyGuestArray);
            $key = key($keyGuestArray);
        }
        echo "</table><br>\n";
    }
    ?>
        <p style="text-align:center">
            <!-- Hyperlink to form to post messages -->
            <a href="PostGuest.php">Post New Message</a>&nbsp; &nbsp; &nbsp;
            <!-- ? is a query string -->
            <!-- Hyperlink to delete first message in array -->
            <a href="GuestBook.php?action=Sort%20Ascending">Sort Subjects A-Z</a> &nbsp; &nbsp; &nbsp;
            <a href="GuestBook.php?action=Sort%20Descending">Sort Subjects Z-A</a> &nbsp; &nbsp; &nbsp;
            <a href="GuestBook.php?action=Delete%20First">Delete First Guest</a> &nbsp; &nbsp; &nbsp;
            <!-- Hyperlink to delete last message in array -->
            <a href="GuestBook.php?action=Delete%20Last">Delete Last Guest</a> &nbsp; &nbsp; &nbsp;
            <!-- Hyperlink to remove message duplicates -->
            <!--<a href="MessageBoard.php?action=Remove%20Duplicates">Remove Duplicates</a>-->
            <br>
        </p>
</body>

</html>
