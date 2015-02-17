<?php


/**
 * Klasi fyrir log in
 */
class Login
{

    private $url = null;


    private $server = null;
    private $username = null;
    private $db = null;

    /**
     * @var object  database tengingin
     */
    private $db_connection = null;
    /**
     * @var array fylki af errors
     */
    public $errors = array();
    /**
     * @var array fylki of success / neutral messages
     */
    public $messages = array();
    


    /**
     * keyrst sjálfkrafa þegar nýtt instance af klasanum Login er búið til
     */
    public function __construct()
    {
        // störtum session
        session_start();
             $url = parse_url(getenv("CLEARDB_DATABASE_URL"));



  $server = $url["host"];
 $username = $url["user"];
 $password = $url["pass"];
  $db = substr($url["path"], 1);

        // ef klikkað er á logout hnappinn
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login með postdata
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    /**
     * log in með post data
     */
    private function dologinWithPostData()
    {
        // athugum login input
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // búum til db tengingu með breytum fra db.php
            //$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            //Heroku CLEARDB:
            $this->db_connection = new mysqli($server, $username, $password, $db);

  

            // breytum í stafasett utf8
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // ef engir errorar
            if (!$this->db_connection->connect_errno) {

                
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);

                // faaum allar upplýsingar um userinn sem var að logg sig inn
                $sql = "SELECT user_name, user_email, user_password_hash
                        FROM users
                        WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);

                // ef userinn er til.
                if ($result_of_login_check->num_rows == 1) {

                    // fáuum niðurstöður
                    $result_row = $result_of_login_check->fetch_object();

                    // athugum hvort saltaða pw passi
                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {

                        // skrifum user gognin í php session (skrá á servernum)
                        $_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_email'] = $result_row->user_email;
                        $_SESSION['user_login_status'] = 1;

                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }

    /**
     * gerum log out
     */
    public function doLogout()
    {
        // eyðum sessioninu af notandanum
        $_SESSION = array();
        session_destroy();
        // skrifum á skjá
        $this->messages[] = "You have been logged out.";

    }

    /**
     * forum aftur a "forsíðu"
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}
