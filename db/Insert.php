<?php

class Insert extends Database {
    // Properties
    private $actionKey; 
    private $firstName, $lastName, $userName, $registrationTime;
    private $passCode, $registrationOrder; 
    private $scoreTime, $finalResult, $livesUsed;

    // Constructor Method 
    public function __construct($key,
        $fn='', $ln='', $un='', $rt='', 
        $pc='', $ro='', 
        $st='', $fr='', $lu='') {

        $this->actionKey = $key;
        $this->firstName = $fn;
        $this->lastName = $ln;
        $this->userName = $un;
        $this->registrationTime = $rt;
        $this->passCode = $pc;
        $this->registrationOrder = $ro;
        $this->scoreTime = $st;
        $this->finalResult = $fr;
        $this->livesUsed = $lu;  
        $this->insertToTAB(); 
    }

    // Method for records insertion 
    private function insertToTAB() {
        // Successful connect to the DBMS 
        if ($this->connectToDBMS() === TRUE) {  
            // Successful connect to the DB
            if ($this->connectToDB('kidsGames') === TRUE) { 
                // Successful table description
                if ($this->executeOneQuery($this->sqlCode()['validateTab']) === TRUE) {
                    // Failed table insert
                    if ($this->executeOneQuery($this->sqlCode()[$this->actionKey]) === FALSE) {
                        die($this->messages()['error']['insertTAB']."<br/>".($this->lastErrMsg));
                    }   
                // Failed table description
                } else {
                    die($this->messages()['error']['descTAB']."<br/>".($this->lastErrMsg));
                }
            // Failed connect to the DB
            } else {
                die($this->messages()['error']['conDB']."<br/>".($this->lastErrMsg));
            }
        // Failed connect to the DBMS
        } else {
            die($this->messages()['error']['conDBMS']."<br/>".($this->lastErrMsg));
        }
    }

    // Method to retrieve the last inserted registrationOrder
  

    // Method for SQL queries
    private function sqlCode() {
        // SQL queries
        $sqlCode['insertIdentity']=
            "INSERT INTO player(fName, lName, userName, registrationTime)
            VALUES('$this->firstName', '$this->lastName', '$this->userName', '$this->registrationTime');";
        
        // Hash the password
        $hashedPassword = password_hash($this->passCode, PASSWORD_DEFAULT);
        
        // Insert query for authenticator with retrieved registrationOrder
        $registrationOrder = $this->getLastInsertedRegistrationOrder();
        $sqlCode['insertCredentials']=
            "INSERT INTO authenticator(passCode, registrationOrder)
            VALUES('$hashedPassword', $registrationOrder);";
                       
        $sqlCode['insertGameScore']=
            "INSERT INTO score(scoreTime, result, livesUsed, registrationOrder)
            VALUES('$this->scoreTime', '$this->finalResult', '$this->livesUsed', '$this->registrationOrder');";
                
        if($this->actionKey === 'insertIdentity')
            $sqlCode['validateTab'] = "DESC player;";
        else if ($this->actionKey === 'insertCredentials')
            $sqlCode['validateTab'] = "DESC authenticator;";
        else if ($this->actionKey === 'insertGameScore')
            $sqlCode['validateTab'] = "DESC score;";

        return $sqlCode;
    }
}

?>
