<?php


/**
 * Klasi fyrir log in
 */
class Login
{
    
    private $db_connection = null;
   
    public $errors = array();
   
    public $messages = array();
    
     // keyrst sjálfkrafa þegar nýtt instance af klasanum Login er búið til 
    public function __construct()
    {
        // störtum session
        session_start();
           

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
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE,DB_PORT);

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
                        echo "<p class='bg-danger'>Notendanafn eða lykilorð er rangt, reyndu aftur!</p>";
                        
                    }
                } else {
                    echo "<p class='bg-danger'>Notendanafn eða lykilorð er rangt, reyndu aftur!</p>";
                    
                }
            } else {
                echo "Database connection problem.";
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
        printf("<script>location.href='index.php'</script>");
        // skrifum á skjá
        $this->messages[] = "You have been logged out.";

    }
    public function getDbConnection()
     {
        
         return new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE,DB_PORT);
     }

    /**
     * forum aftur a "forsíðu"
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
