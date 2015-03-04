<?php

/**
 * klasi fyrir nyskraningu
 * 
 */
class Registration
{
    /**
<<<<<<< HEAD
     * @var object $db_connection The database connection tengingin
=======
     * @var object $db_connection database tengingin
>>>>>>> 5f11c09be418af0d151e69204e22907b3218942a
     */
    private $db_connection = null;
    /**
     * @var array $errors fylki af errors
     */
    public $errors = array();
    /**
     * @var array $messages fylki af skilboðum
     */
    public $messages = array();

    /**
<<<<<<< HEAD
<<<<<<< HEAD
     * keyrist sjálfkrafa þegar nýtt instance af registaration er búið til.        
=======
     * keyrist sjálfkrafa þegar nýtt object af registaration er búið til.        
>>>>>>> FETCH_HEAD
=======
     * keyrist sjálfkrafa þegar nýtt object af registaration er búið til.        
>>>>>>> 5f11c09be418af0d151e69204e22907b3218942a
     */
    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    /**
     * athugum með errora í register inputinu , og búum svo til nýjan user.
     */
    private function registerNewUser()
    {
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "Password and password repeat are not the same";
        } elseif (strlen($_POST['user_password_new']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } elseif (empty($_POST['user_email'])) {
            $this->errors[] = "Email cannot be empty";
        } elseif (strlen($_POST['user_email']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
        } elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            // búum til database tengingu
<<<<<<< HEAD
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);


            //Heroku database tenging
             //$this->db_connection = new mysqli($server, $username, $password, $db);
=======
           // $this->db_connection = new mysqli(server, user, pw, db);


            //Heroku database tenging
             $this->db_connection = new mysqli($server, $username, $password, $db);
>>>>>>> 5f11c09be418af0d151e69204e22907b3218942a




            // setjum stafasett sem utf8
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // athugum hvort database tengingin se ekki í lagi,
            if (!$this->db_connection->connect_errno) {

                // fjarlægum allt sem getur verið html og js kóði
                $user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
                $user_email = $this->db_connection->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));

                $user_password = $_POST['user_password_new'];

                // Söltum þetta password
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                // athugum hvort username er nokkuð nú þegar til
                $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';";
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) {
                    $this->errors[] = "Sorry, that username / email address is already taken.";
                } else {
                    // skrifum nýja userinn í databaseið
                    $sql = "INSERT INTO users (user_name, user_password_hash, user_email)
                            VALUES('" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "');";
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // usernum hefur verið bætt við
                    if ($query_new_user_insert) {
                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
                echo mysql_error();
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
}
