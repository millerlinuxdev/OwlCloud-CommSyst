<?php
session_start();
if(isset($_GET['logout'])){    

  // Simple exit message 
    $logout_message = "<br><div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span><br></div><br>";
    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);

  session_destroy();
  header("Location: owlcloud.php"); // Redirect the user 
}
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}
function loginForm(){
    echo 
    '<div id="loginform"> 
<p>Please enter your name to continue!</p> 
<form action="owlcloud.php" method="post"> 
<label for="name">Name &mdash;</label> 
<input type="text" name="name" id="name" /> 
<input type="submit" name="enter" id="enter" value="Enter" /> 
</form> 
</div>';
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>SkyLink</title>
        <meta name="description" content="Tuts+ Chat Application" />
        <link rel="stylesheet" href="style.css" />
        <style>
          @import url('https://fonts.cdnfonts.com/css/w95fa');

            * {
              margin: 0;
              padding: 0;
              box-sizing: border-box;
            }

            body {
              background-color: #000000; /* Light gray background */
              font-family: 'W95FA', sans-serif;
              font-weight: normal;
              color: white;
              padding: 10px;
              overflow: hidden;
            }

            form {
              padding: 10px;
              display: flex;
              gap: 10px;
              justify-content: center;
            }

            form label {
              font-size: 12px;
              font-weight: bold;
              color: white;
            }

            input, select, textarea {
              font-family: 'W95FA', sans-serif;
              font-size: 12px;
              padding: 4px;
              border: 2px solid #fff; /* Windows 95 blue border */
              border-radius: 2px;
              background-color: #000000;
              color: white;
              box-shadow: inset 1px 1px 3px rgba(0, 0, 0, 0.2); /* Subtle inset shadow for a more authentic look */
            }

            a {
              color: #fff;
              text-decoration: none;
            }

            a:hover {
              text-decoration: underline;
            }

            #wrapper,
            #loginform {
              margin: 0 auto;
              padding: 10px;
              background: #000000; /* Windows 95 light gray */
              width: 600px;
              max-width: 100%;
              border: 2px solid #fff; /* Windows 95 blue */
              border-radius: 2px;
              box-shadow: inset 1px 1px 3px rgba(0, 0, 0, 0.2); /* Subtle 3D inset shadow */
            }

            #loginform {
              padding-top: 10px;
              text-align: center;
            }

            #loginform p {
              padding: 10px;
              font-size: 14px;
              font-weight: normal;
            }

            #chatbox {
              text-align: left;
              margin: 0 auto;
              margin-bottom: 20px;
              padding: 10px;
              background: #000000; /* White background for chat */
              height: 300px;
              width: 530px;
              border: 2px solid #fff; /* Blue border */
              border-radius: 2px;
              box-shadow: inset 1px 1px 3px rgba(0, 0, 0, 0.2); /* Subtle 3D effect */
              overflow-y: auto;
            }

            #usermsg {
              flex: 1;
              border: 2px solid #fff;
              background: black;
              color: white;
            }

            #name {
              border-radius: 2px;
              border: 2px solid #fff;
              padding: 2px 8px;
              background: black;
              color: white;
            }

            #submitmsg,
            #enter {
              background: #000;
              border: 2px solid #fff;
              color: white;
              padding: 4px 10px;
              font-weight: bold;
              border-radius: 2px;
              box-shadow: inset 1px 1px 3px rgba(0, 0, 0, 0.2); /* Simulate the inset shadow of classic buttons */
            }

            .error {
              color: #ff0000;
            }

            #menu {
              padding: 10px;
              display: flex;
              background: #000000; /* Darker gray background */
              border: 2px solid #fff; /* Blue top border */
            }

            #menu p.welcome {
              flex: 1;
              color: #fff;
            }

            a#exit {
              color: white;
              background: #800000; /* Dark red */
              padding: 3px 8px;
              border-radius: 2px;
              font-weight: bold;
              text-decoration: none;
              text-align: center;
            }

            a#exit:hover {
              background: #b00000; /* Lighter red on hover */
            }

            .msgln {
              margin: 0 0 5px 0;
              color: white;
            }

            .msgln span.left-info {
              color: #fff; /* Orange-ish color for info */
            }

            .msgln span.chat-time {
              color: #fff;
              font-size: 13px;
              vertical-align: super;
            }

            .msgln b.user-name, .msgln b.user-name-left {
              font-weight: bold;
              background: #1c1c1c; /* Dark background for user name */
              color: white;
              padding: 2px 4px;
              font-size: 90%;
              border-radius: 2px;
              margin: 0 5px 0 0;
              cursor: pointer;
            }

            .msgln b.user-name-left {
              background: #800000; /* Orange for left user */
            }

            #contextMenu {
                display: none;
                position: absolute;
                background-color: #1c1c1c;
                border: 2px solid #fff;
                border-radius: 5px;
                padding: 5px;
                z-index: 999;
            }

            #contextMenu ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            #contextMenu li {
                padding: 5px;
                cursor: pointer;
            }

            #contextMenu li:hover {
                background-color: #333;
            }
        </style>
    </head>
    <body>
    <?php
    if(!isset($_SESSION['name'])){
        loginForm();
    }
    else {
    ?>
      <div style="text-align: center;">
      <pre style="border: 2px solid #fff; border-radius: 2px; padding: 10px; display: inline-block; word-wrap: break-word;"><center>
  ___         _  ___ _             _ 
 / _ \__ __ _| |/ __| |___ _  _ __| |
| (_) \ V  V / | (__| / _ \ || / _` |
 \___/ \_/\_/|_|\___|_\___/\_._\__._|

      </center></pre>
      </div>
      <br><br>
        <div id="wrapper">
            <div id="menu">
                <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
                <p class="logout"><a id="exit" href="saturn.dos">Exit Chat</a></p>
            </div>
          <br>
            <div id="chatbox">
            <?php
            if(file_exists("log.html") && filesize("log.html") > 0){
                $contents = file_get_contents("log.html");          
                echo $contents;
            }
            ?>
            </div>
            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
            </form>
        </div>
        <div id="contextMenu">
            <ul>
                <li><a href="#" id="replyOption">Reply</a></li>
                <li><a href="#" id="viewProfileOption">View Profile</a></li>
            </ul>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                // Show context menu when username is clicked
                $(".user-name-left, .user-name").on("click", function (e) {
                    e.preventDefault();
                    var username = $(this).text();
                    $("#contextMenu").css({
                        "top": e.pageY + "px",
                        "left": e.pageX + "px"
                    }).show();

                    // Store the username in a variable for the reply function
                    $("#replyOption").off("click").on("click", function () {
                        $("#usermsg").val("@" + username + " "); // Focus reply with '@username'
                        $("#usermsg").focus();
                        $("#contextMenu").hide(); // Hide menu after selecting reply
                    });

                    // Additional functionality for View Profile
                    $("#viewProfileOption").off("click").on("click", function () {
                        alert("Viewing profile of " + username); // Customize as needed
                        $("#contextMenu").hide();
                    });
                });

                // Hide context menu if clicking elsewhere
                $(document).on("click", function (e) {
                    if (!$(e.target).closest('#contextMenu').length && !$(e.target).closest('.user-name').length) {
                        $("#contextMenu").hide();
                    }
                });

                // Send message on click
                $("#submitmsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", { text: clientmsg });
                    $("#usermsg").val("");
                    return false;
                });

                // Load chat log every 2.5 seconds
                function loadLog() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; // Scroll height before the request 
                    $.ajax({
                        url: "log.html",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(html); // Insert chat log into the #chatbox div 
                            // Auto-scroll 
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; // Scroll height after the request 
                            if(newscrollHeight > oldscrollHeight){
                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); // Auto scroll to bottom of div 
                            }	
                        }
                    });
                }
                setInterval (loadLog, 2500);

                // Exit chat functionality
                $("#exit").click(function () {
                    var exit = confirm("Are you sure you want to end the session?");
                    if (exit == true) {
                    window.location = "index.php?logout=true";
                    }
                });
            });
        </script>
    </body>
</html>
<?php
}
?>