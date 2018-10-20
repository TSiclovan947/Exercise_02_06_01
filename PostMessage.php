<!doctype html>

<html>

<head>
    <!--   
         Exercise 02_06_01
         Author: Tabitha Siclovan
         Date: October 19, 2018
        
         PostMessage.php
    -->
    <title>Post New Massage</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <?php
    //Entry Point
    //Data submitted? Yes - Process. No - Display Form.
            //isset = array function, takes in array and label/key 
            //to a particular field and tells if it exists
    //See if form has been sent
    if (isset($_POST['submit'])) {
        //If form has been sent, creates subject variable
        $subject = stripslashes($_POST['subject']);
        $name = stripslashes($_POST['name']);
        $message = stripslashes($_POST['message']);
        //Replaces tildys (~) with dash (-)
        $subject = str_replace("~", "-", $subject);
        $name = str_replace("~", "-", $name);
        $message = str_replace("~", "-", $message);
        $messageRecord = "$subject~$name~$message\n";
        //echo $messageRecord; //debug
        $fileHandle = fopen("messages.txt", "ab");
        if (!$fileHandle) {
            //Failure
            echo "There was an error saving your message!\n";
        }
        else {
            fwrite($fileHandle, $messageRecord);
            //Success
            fclose($fileHandle);
            echo "Your message has been saved.\n";
        }
    }
    ?>
    <!-- HTML Form (for submission) -->
    <h1>Post New Message</h1>
    <hr>
    <form action="PostMessage.php" method="post">
        <span style="font-weight: bold">Subject: <input type="text" name="subject"></span>
        <span style="font-weight: bold">Name: <input type="text" name="name"></span><br>
        <textarea name="message" rows="6" cols="80" style="margin: 10px 5px 5px"></textarea><br>
        <input type="reset" name="reset" value="Reset Form">
        <input type="submit" name="submit" value="Post Message">
    </form>
    <hr>
    <p>
        <a href="MessageBoard.php">View Messages</a>
    </p>
</body>

</html>
