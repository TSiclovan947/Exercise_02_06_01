<!doctype html>

<html>

<head>
    <!--   
         Exercise 02_06_01
         Author: Tabitha Siclovan
         Date: October 24, 2018
        
         PostGuest.php
    -->
    <title>Post Guest</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body style="background-color: rgb(208, 248, 255)">
    <?php
    //Entry Point
    //Data submitted? Yes - Process. No - Display Form.
            //isset = array function, takes in array and label/key 
            //to a particular field and tells if it exists
    //See if form has been sent
    if (isset($_POST['submit'])) {
        //If form has been sent, creates subject variable
        $fname = stripslashes($_POST['fname']);
        $lname = stripslashes($_POST['lname']);
        $email = stripslashes($_POST['email']);
        $existingNames = array();
        if (file_exists("Guests.txt") && filesize("Guests.txt") > 0) {
            $guestArray = file("Guests.txt");
            $count = count($guestArray);
            //echo "$count<br>";
            for ($i = 0; $i < $count; $i++) {
                $currMsg = explode("~", $guestArray[$i]);
                //Creating array of just subject fields
                $existingNames[] = $currMsg[0];
            }
        }
        //Designed to test keys, not values
        //Does this key exist in array?
        if (in_array($fname, $existingNames)) {
            echo "<p>The Name <em>\"$fname $lname\"</em> you entered already exists!<br>\n";
            echo "Please enter a new Guest Name and try again.<br>\n";
            $fname = "";
        }
        else {
            $guestNameRecord = "$fname~$lname~$email\n";
            //echo $messageRecord; //debug
            $fileHandle = fopen("Guests.txt", "ab");
            if (!$fileHandle) {
                //Failure
                echo "There was an error saving your guest name!\n";
            }
            else {
                fwrite($fileHandle, $guestNameRecord);
                //Success
                fclose($fileHandle);
                echo "Your message has been saved.\n";
                $fname = "";
                $lname = "";
                $email = "";
            }
        }       
    }
    else {
        $fname = "";
        $lname = "";
        $email = "";
    }
    ?>
    <!-- HTML Form (for submission) -->
    <h1 style="text-align: center">Guest Visitor Sign-In</h1>
    <hr>
    <br>
    <form action="PostGuest.php" method="post" style="text-align:center">
        <span style="font-weight: bold">First Name: <input type="text" name="fname" value="<?php echo $fname;?>"></span><br><br><br>
        <span style="font-weight: bold">Last Name: <input type="text" name="lname" value="<?php echo $lname; ?>"></span><br><br><br>
        <span style="font-weight: bold">Email Address: <input type="email" name="email" value="<?php echo $email; ?>"></span><br><br><br>
        <input type="reset" name="reset" value="Reset Form">
        <input type="submit" name="submit" value="Sign-In">
    </form>
    <br>
    <hr>
    <br>
    <p style="text-align: center">
        <a href="GuestBook.php">View Guest Visitor</a>
    </p>
</body>

</html>
