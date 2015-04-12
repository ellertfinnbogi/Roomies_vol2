<?php
class UserFunctions
{
    
    private $db_connection = null;
    
    public $errors = array();
    
    public $messages = array();

    public function savejob()
    {
 
            // búum til database tengingu

            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);


            // setjum stafasett sem utf8
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // athugum hvort database tengingin se ekki í lagi,
           if (!$this->db_connection->connect_errno) {



           	//GOTT TIL AÐ AHTUGA HVORT TENGIN VIÐ DB SÉ Í LAGI
            /*	if ($this->db_connection->ping()) {
    				printf ("Our connection is ok!\n");
				} else {
    				printf ("Error: %s\n", $db_connection->error);
					}*/

                // fjarlægum allt sem getur verið html og js kóði
                $todo = $this->db_connection->real_escape_string(strip_tags($_POST['todo_list'], ENT_QUOTES));
                $user_resp = $this->db_connection->real_escape_string(strip_tags($_POST['personresponsible'], ENT_QUOTES));
                $date = $this->db_connection->real_escape_string(strip_tags($_POST['date'], ENT_QUOTES));
                // kúnst til að snúa við strengnum sem inniheldur dagsetningu
                $temp_year = substr($date,0,4);
                $temp_month = substr($date,4,3);
                $temp_date = substr($date,8,2);
                $date_temp = $temp_date. $temp_month .'-'. $temp_year;
                

  
                    // skrifum nýtt verkefni í gagangrunn
                    $sql = "INSERT INTO todo (user_name,room,todo,user_resp,do_date,reg_date)
                            VALUES('".$_SESSION['user_name']."','".$_SESSION['room']."','".$todo."', '".$user_resp."', '".$date_temp."', DATE_FORMAT(NOW(),'%d-%m-%Y'));";
                            
                    $query_new_job_insert = $this->db_connection->query($sql);

                    // verkefni hefur verið bætt við
                    if ($query_new_job_insert) {
                        printf("<script>location.href='logged_in.php'</script>");
                    } else {
                        $this->errors[] = "Eitthvað klikkaði við skráningu nýs verkefnis, vinsamlegast farðu tilbaka og reyndu aftur";
                    }
                }

    }
    public function savepayment()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);


        // setjum stafasett sem utf8
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }

        // athugum hvort database tengingin se ekki í lagi,
       if (!$this->db_connection->connect_errno) {



        //GOTT TIL AÐ AHTUGA HVORT TENGIN VIÐ DB SÉ Í LAGI
        /*  if ($this->db_connection->ping()) {
                printf ("Our connection is ok!\n");
            } else {
                printf ("Error: %s\n", $db_connection->error);
                }*/

            // fjarlægum allt sem getur verið html og js kóði
            $payment_amount = $this->db_connection->real_escape_string(strip_tags($_POST['payment_amount'], ENT_QUOTES));
            $payment = $this->db_connection->real_escape_string(strip_tags($_POST['payment'], ENT_QUOTES));
            $date = $this->db_connection->real_escape_string(strip_tags($_POST['date'], ENT_QUOTES));
            // kúnst til að snúa við strengnum sem inniheldur dagsetningu
            $temp_year = substr($date,0,4);
            $temp_month = substr($date,4,3);
            $temp_date = substr($date,8,2);
            $date_temp = $temp_date. $temp_month .'-'. $temp_year;
            


                // skrifum nýtt verkefni í gagangrunn
                $sql = "INSERT INTO payment (room,user_name,value,about_pay,reg_date)
                        VALUES('".$_SESSION['room']."','".$_SESSION['user_name']."','".$payment_amount."','".$payment."',DATE_FORMAT(NOW(),'%d-%m-%Y'));"; 
                      
                        
                $query_new_job_insert = $this->db_connection->query($sql);

                // verkefni hefur verið bætt við
                if ($query_new_job_insert) {
                    printf("<script>location.href='logged_in.php'</script>");
                } else {
                    $this->errors[] = "Eitthvað klikkaði við skráningu nýs verkefnis, vinsamlegast farðu tilbaka og reyndu aftur";
                   
                }
            }

    }


    public function jobsetasdone()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);


        // setjum stafasett sem utf8
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }

        // athugum hvort database tengingin se ekki í lagi,
       if (!$this->db_connection->connect_errno) {

            $todo_id= $this->db_connection->real_escape_string(strip_tags($_POST['todo_id'], ENT_QUOTES));

          
                // skrifum nýtt verkefni í gagangrunn
                $sql ="UPDATE todo SET done_bool = 'X' WHERE id = $todo_id";
                        
                $query_new_job_insert = $this->db_connection->query($sql);

                // verkefni hefur verið bætt við
                if ($query_new_job_insert) {
                    printf("<script>location.href='logged_in.php'</script>");
                } else {
                    $this->errors[] = "Eitthvað klikkaði við að skrá verk sem klárað";
                   
                }
            }

    }

    public function jobsetnotdone()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);


        // setjum stafasett sem utf8
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }

        // athugum hvort database tengingin se ekki í lagi,
       if (!$this->db_connection->connect_errno) {

            $todo_id= $this->db_connection->real_escape_string(strip_tags($_POST['todo_id'], ENT_QUOTES));

          
                // skrifum nýtt verkefni í gagangrunn
                $sql ="UPDATE todo SET done_bool = null WHERE id = $todo_id";
                        
                $query_new_job_insert = $this->db_connection->query($sql);

                // verkefni hefur verið bætt við
                if ($query_new_job_insert) {
                    printf("<script>location.href='logged_in.php'</script>");
                } else {
                    $this->errors[] = "Eitthvað klikkaði við að skrá verk sem klárað";
                   
                }
            }

    }
    public function createroom()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);


        // setjum stafasett sem utf8
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }

        // athugum hvort database tengingin se ekki í lagi,
       if (!$this->db_connection->connect_errno) {

            $roomname= $this->db_connection->real_escape_string(strip_tags($_POST['roomname'], ENT_QUOTES));
            $roomrent= $this->db_connection->real_escape_string(strip_tags($_POST['rent'], ENT_QUOTES));
            $random_room = substr(md5(rand()), 0, 12);
            $user = $_SESSION['user_name'];
                // skrifum nýtt verkefni í gagangrunn
               // $sql ="UPDATE users SET done_bool = null WHERE id = $todo_id";
              //  $sql "INSERT INTO users (room_name, room_rent,room) WHERE $_SESSION['user_name'] = user_name
                     // VALUES('".$roomname."','".$roomrent."','".$random_room."');";
                       // echo $sql;
                $sql ="UPDATE users SET room_name = '$roomname',room_rent = '$roomrent',room = '$random_room' WHERE user_name = '$user'";
               
                $query_new_job_insert = $this->db_connection->query($sql);
               

                // verkefni hefur verið bætt við
                if ($query_new_job_insert) {
                        printf("<script>location.href='logged_in.php'</script>");
                } else {
                    $this->errors[] = "FAILED";
                   
                }
            }
    }






}
?>