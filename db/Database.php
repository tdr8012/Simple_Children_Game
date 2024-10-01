<?php

class Database {
    // Properties
    private $connection, $sqlExec; 
    protected $lastErrMsg, $selectedRows;

    //Constructor Method //
    public function __construct(){
            $this->connectToDBMS();
    }

    //Method for customized Messages
    public function messages()
    {
        //Error messages 
        $m['conDBMS'] = "Connection to MySQL failed!";
        $m['creatEntity'] = "Creation of the DB, Table, or View failed!";
        $m['conDB'] = "Connection to the DB failed!";
        $m['insertTAB'] = "Data insertion to the Table failed!";
        $m['selectTAB'] = "Data selection from the Table failed!";
        $m['descTAB'] = "Table structure description failed!";
        $m['updateCOL']= "Table Column Update failed!";
        //Try again messages
        $l['tryAgain'] = "<a href=\"index.php\"><input type=\"submit\" value=\"Try again!\"></a>";
        //Group messages by category 
        $msg['error'] = $m;
        $msg['link'] = $l;
        return $msg;
    }
    
    //Method for DBMS Connection 
    public function connectToDBMS()
    {
        //Attempt to connect to MySQL using MySQLi
        $con = new mysqli('localhost','root', '');
        //If connection to the MySQL failed save the system error message 
        if ($con->connect_error) {
            $this->lastErrMsg = mysqli_connect_error();
            return FALSE;
        } else {
            $this->connection = $con;
            return TRUE;
        }
    }

    //Method for DB Connection 
    public function connectToDB($dbname)
    {
        //Attempt to select the database
        $con = mysqli_select_db($this->connection, $dbname);
        //If selection of the Database failed save a custom error message 
        if ($con === FALSE) {
            $this->lastErrMsg = "Failed to select database: $dbname";
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //Method for multiple SQL Query Execution 
    public function executeMultiQuery($sqlcode)
    {
        //Attempt to execute the query
        $invokeQuery = ($this->connection)->multi_query($sqlcode);
        //If query execution failed save the system error message  
        if ($invokeQuery === FALSE) {
            $this->lastErrMsg = ($this->connection)->error;
            return FALSE;
        } else {
            $this->sqlExec = $invokeQuery;
            return TRUE;
        }
    }   

    //Method for one SQL Query Execution 
    public function executeOneQuery($sqlcode)
    {
        //Attempt to execute the query
        $invokeQuery = ($this->connection)->query($sqlcode);
        //If query execution failed save the system error message  
        if ($invokeQuery === FALSE) {
            $this->lastErrMsg = ($this->connection)->error;
            return FALSE;
        } else {
            return $invokeQuery; // Return the result object
        }
    }

    //Method for Selected Data Recording
    public function saveSelectedData(){
        //Calculate the number of rows available
        $number_of_rows = ($this->sqlExec)->num_rows;
        if ($number_of_rows==0){
            $this->selectedRows=NULL;
        } else {
            //Use a loop to display the rows one by one
            $data=array();
            for ($i = 1; $i <= $number_of_rows; ++$i) {
                //Assign the records of each row to an associative array
                $each_row = $this->sqlExec->fetch_array(MYSQLI_ASSOC);
                //Display each the record corresponding to each column
                //Save all the records to a multidimensional associative array
                foreach ($each_row as $section => $item)
                    $data["row$i"]["$section"]=$item;    
            } 
            $this->selectedRows=$data;  
        }
    }
    public function getConnection() {
        return $this->connection;
    }
    public function getLastErrorMessage() {
        return $this->lastErrMsg;
    }
     //Destructor Method
     public function __destruct()
     {
         //Close automatically the DBMS connection           
         if ($this->connection !== NULL)
             $this->connection->close();
     }

    // Other methods and properties...

    public function numRows($result) {
        return mysqli_num_rows($result);
    }

    // Method to fetch the result set as an associative array
    public function fetchAssoc($result) {
        return mysqli_fetch_assoc($result);
    }

    // Method to retrieve the last inserted registrationOrder
    public function getLastInsertedRegistrationOrder() {
        // Query to retrieve the last inserted registrationOrder from the player table
        $query = "SELECT MAX(registrationOrder) AS registrationOrder FROM player;";
        
        // Execute the query
        $result = $this->executeOneQuery($query);

        // Check if query was successful
        if ($result !== FALSE && $this->numRows($result) > 0) {
            $row = $this->fetchAssoc($result);
            return $row['registrationOrder'];
        } else {
            // Handle error if query fails
            die($this->messages()['error']['getLastInsertedRegistrationOrder']."<br/>".($this->lastErrMsg));
        }
    }

    // Other methods...

    public function prepare($sql) {
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            $this->lastErrMsg = $this->connection->error;
        }
        return $stmt;
    }
}

?>