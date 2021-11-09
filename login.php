<?php // Script 8.8 - login.php
session_start();
require_once "classes/component.php";
$titel = "Logga in | WEfit ";
menu($titel);

print '<h2>Login Form</h2>
    <p>Users who are logged in can take advantage of
    certain features like this, that, and the
    other thing.</p>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ((!empty($_POST['email'])) &&
        (!empty($_POST['password']))
    ) {
        if ((strtolower($_POST['email']) == 'me@example.com') && ($_POST['password'] ==
            'testpass')) { // Correct!
            print '<p class="text--success">You are logged in!</p>';
            print '<p>Now you can blah, blah, blah... </p>';

        } else { // Incorrect!
            print '<p class="text--error">The submitted email address and password do not match
                    those on file!<br>Go back and try again.</p>';
        }
    } else { // Forgot a field.
        print '<p class="text--error">Please make sure you enter both an email address and a
                password!<br>Go back and try again.</p>';
    }
} else { // Display the form.
    include ("login.html");
}
