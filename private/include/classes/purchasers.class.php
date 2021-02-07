<?php
class Purchasers {

    private $Database;
    private $Functions;

    /** @var array $purchasersArray */
    public $purchasersArray = array();

    /**
     * @param Database $database
     * @param Functions $functions
     */
    function __construct($database, $functions) {
        $this->Database = $database;
        $this->Functions = $functions;
        $this->populateArray();
    }

    private function populateArray() {
        $sql = "SELECT id, username, email FROM users WHERE user_type = :user_type ";
        $stmt = $this->Database->prepare($sql);
        $stmt->bindValue(':user_type', Constants::USER_TYPE_PURCHASING_PERSON, PDO::PARAM_STR);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            array_push($this->purchasersArray, $sanitizedArray);
        }
    }

    /**
     * @return array $purchasersArray
     */
    public function getPurchasersArray() {
        return $this->purchasersArray;
    }
    
    /**
     * @return boolean Returns true if the logged in user is a purchasing person
     */
    public function isPurchaser() {
        $userId = $_SESSION['id'];
        $purchasersArray = $this->purchasersArray;
        
        $isPurchaser = false;
        
        foreach ($purchasersArray as $purchaser) {
            if ($purchaser['id'] == $userId) {
                $isPurchaser = true;
            }
        }
        
        return $isPurchaser;
    }

}
?>