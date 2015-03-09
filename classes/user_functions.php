<?php
class UserFunctions
{
    /**
     * @var object $db_connection The database connection tengingin
     * @var object $db_connection database tengingin
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
     * keyrist sjálfkrafa þegar nýtt instance af registaration er búið til.        
     * keyrist sjálfkrafa þegar nýtt object af registaration er búið til.        
     * keyrist sjálfkrafa þegar nýtt object af registaration er búið til.        
     */
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

                $temp_year = substr($date,0,4);
                $temp_month = substr($date,4,3);
                $temp_date = substr($date,8,2);
                $date_temp = $temp_date. $temp_month .'-'. $temp_year;
                

  
                    // skrifum nýtt verkefni í gagangrunn
                    $sql = "INSERT INTO todo (user_name,room,todo,user_resp,do_date,reg_date)
                            VALUES('".$_SESSION['user_name']."','".$_SESSION['room']."','".$todo."', '".$user_resp."', '".$date_temp."', DATE_FORMAT(NOW(),'%d-%m-%Y'));";
                            
                    $query_new_job_insert = $this->db_connection->query($sql);

                    // verkefnihefur verið bætt við
                    if ($query_new_job_insert) {
                        //header('Location: logged_in.php?success=true');
                        printf("<script>location.href='logged_in.php'</script>");
                    } else {
                        $this->errors[] = "Eitthvað klikkaði við skráningu nýs verkefnis, vinsamlegast farðu tilbaka og reyndu aftur";
                    }
                }

    }









}
?>