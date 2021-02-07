<?php
class ItemDetails {

    private $Database;
    private $Functions;
    private $Email;
    private $Vendors;
    private $Admin;
    private $isAdmin = false;

    /**
     * @param Database $database
     * @param Functions $functions
     * @param Vendors $vendors
     */
    function __construct($database, $functions, $vendors, $email, $admin) {
        $this->Database = $database;
        $this->Functions = $functions;
        $this->Vendors = $vendors;
        $this->Email = $email;
        $this->Admin = $admin;

        if ($this->Admin->isAdmin()) {
            $this->isAdmin = true;
        }
    }

    public function getVendors() {
        $vendorsArray = $this->Vendors->getVendorsArray();
        echo '<select id="item-details-popup-window-vendor">';
        echo '<option></option>';
        foreach ($vendorsArray as $id => $vendor) {
            $vendorName = $vendor['name'];
            echo "<option value='$id'>$vendorName</option>";
        }
        echo '</select>';
    }

    /**
     * @param array $itemDetailsArray
     * @return boolean PDO execute result
     */
    public function updateItemDetails($itemDetailsArray) {
        $vendorsArray = $this->Vendors->getVendorsArray();
        $description = $itemDetailsArray['description'];
        $quantity = $itemDetailsArray['quantity'];
        $uom = $itemDetailsArray['uom'];
        $vendorId = $itemDetailsArray['vendor'];
        $vendorName = $vendorsArray[$vendorId]['name'];
        $catalogNo = $itemDetailsArray['catalog_no'];
        $price = $itemDetailsArray['price'];
        $weblink = $this->Functions->addHttp($itemDetailsArray['weblink']);
        $costCenter = $itemDetailsArray['cost_center'];
        $projectId = $itemDetailsArray['project'];
        $comments = $itemDetailsArray['comments'];
        $sds = $itemDetailsArray['sds'];
        $orderId = trim(substr($itemDetailsArray['order_id'], 5));
        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

        if ($this->isAdmin) {
            $status = $itemDetailsArray['status'];
            $invoiceNo = $itemDetailsArray['invoice_no'];
            $vendorOrderNo = $itemDetailsArray['vendor_order_no'];

            $statusChanged = true;
            if ($status == 'no_change') {
                $statusChanged = false;
            }
        }

        // Inserting the information to the database
        $sql = "UPDATE orders SET ";
        $sql .= "description = :description, ";
        $sql .= "quantity = :quantity, ";
        $sql .= "uom = :uom, ";
        $sql .= "vendor = :vendor, ";
        $sql .= "vendor_name = :vendor_name, ";
        $sql .= "catalog_no = :catalog_no, ";
        $sql .= "price = :price, ";
        $sql .= "weblink = :weblink, ";
        $sql .= "cost_center = :cost_center, ";
        $sql .= "project = :project, ";
        $sql .= "comments = :comments, ";
        $sql .= "sds = :sds, ";

        if ($this->isAdmin) {
            if ($statusChanged) {
                if ($status == 'Ordered') {
                    $sql .= "ordered = :ordered, ";
                    $sql .= "ordered_date = :ordered_date, ";
                    $sql .= "ordered_by_user_id = :ordered_by_user_id, ";
                    $sql .= "ordered_by_username = :ordered_by_username, ";
                } else if ($status == 'Delivered') {
                    $sql .= "delivered = :delivered, ";
                    $sql .= "delivered_date = :delivered_date, ";
                    $sql .= "delivered_by_user_id = :delivered_by_user_id, ";
                    $sql .= "delivered_by_username = :delivered_by_username, ";
                }

                if ($status != 'Ordered' && $status != 'Delivered' && $status != 'In Concur' && $status != 'Archived') {
                    $sql .= "ordered = :ordered, ";
                }

                if ($status != 'Delivered' && $status != 'In Concur' && $status != 'Archived') {
                    $sql .= "delivered = :delivered, ";
                }
                $sql .= "status = :status, ";
                $sql .= "status_updated_date = :status_updated_date, ";
                $sql .= "status_updated_by_user_id = :status_updated_by_user_id, ";
                $sql .= "status_updated_by_username = :status_updated_by_username, ";
            }
            $sql .= "invoice_no = :invoice_no, ";
            $sql .= "vendor_order_no = :vendor_order_no, ";
        }

        $sql .= "last_updated_by_id = :last_updated_by_id, ";
        $sql .= "last_updated_by_username = :last_updated_by_username, ";
        $sql .= "last_updated_datetime = :last_updated_datetime ";
        $sql .= "WHERE id = :order_id";

        $stmt = $this->Database->prepare($sql);

        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_STR);
        $stmt->bindValue(':uom', $uom, PDO::PARAM_STR);
        $stmt->bindValue(':vendor', $vendorId, PDO::PARAM_STR);
        $stmt->bindValue(':vendor_name', $vendorName, PDO::PARAM_STR);
        $stmt->bindValue(':catalog_no', $catalogNo, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':weblink', $weblink, PDO::PARAM_STR);
        $stmt->bindValue(':cost_center', $costCenter, PDO::PARAM_STR);
        $stmt->bindValue(':project', $projectId, PDO::PARAM_STR);
        $stmt->bindValue(':comments', $comments, PDO::PARAM_STR);
        $stmt->bindValue(':sds', $sds, PDO::PARAM_STR);

        if ($this->isAdmin) {
            if ($statusChanged) {
                if ($status == 'Ordered') {
                    $stmt->bindValue(':ordered', "1", PDO::PARAM_STR);
                    $stmt->bindValue(':ordered_date', $currentDate, PDO::PARAM_STR);
                    $stmt->bindValue(':ordered_by_user_id', $userId, PDO::PARAM_STR);
                    $stmt->bindValue(':ordered_by_username', $username, PDO::PARAM_STR);
                } else if ($status == 'Delivered') {
                    $stmt->bindValue(':delivered', "1", PDO::PARAM_STR);
                    $stmt->bindValue(':delivered_date', $currentDate, PDO::PARAM_STR);
                    $stmt->bindValue(':delivered_by_user_id', $userId, PDO::PARAM_STR);
                    $stmt->bindValue(':delivered_by_username', $username, PDO::PARAM_STR);
                }

                if ($status != 'Ordered' && $status != 'Delivered' && $status != 'In Concur' && $status != 'Archived') {
                    $stmt->bindValue(':ordered', "0", PDO::PARAM_STR);
                }

                if ($status != 'Delivered' && $status != 'In Concur' && $status != 'Archived') {
                    $stmt->bindValue(':delivered', "0", PDO::PARAM_STR);
                }
                $stmt->bindValue(':status', $status, PDO::PARAM_STR);
                $stmt->bindValue(':status_updated_by_user_id', $userId, PDO::PARAM_STR);
                $stmt->bindValue(':status_updated_by_username', $username, PDO::PARAM_STR);
                $stmt->bindValue(':status_updated_date', $currentDate, PDO::PARAM_STR);
            }
            $stmt->bindValue(':invoice_no', $invoiceNo, PDO::PARAM_STR);
            $stmt->bindValue(':vendor_order_no', $vendorOrderNo, PDO::PARAM_STR);
        }
        
        $stmt->bindValue(':last_updated_by_id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_by_username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_datetime', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function sendStatusChangeEmail($orderId, $status) {
        $sql = "SELECT o.requested_by_username, o.description, u.email FROM orders o JOIN users u ON o.requested_by_id = u.id WHERE o.id = :orderId";
        $stmt = $this->Database->prepare($sql);

        $stmt->bindValue(':orderId', $orderId, PDO::PARAM_STR);
        $stmt->execute();

        $sanitizedArray = $this->Functions->sanitizeArray($stmt->fetch(PDO::FETCH_ASSOC));

        $userFirstName = $this->Functions->getUserFirstName($sanitizedArray['requested_by_username']);
        $userEmail = $sanitizedArray['email'];

        $itemDescription = $sanitizedArray['description'];
        $subject = "OMS Notification: Order Status Change";
        $messageBody = "<p>The status for '$itemDescription' was updated to '$status'.</p>";

        $this->Email->sendEmail($userEmail, $userFirstName, $subject, $messageBody);
    }
    
    function getItemOrderStatus($orderId) {
        $sql = "SELECT status FROM orders WHERE id = :orderId";
        $stmt = $this->Database->prepare($sql);

        $stmt->bindValue(':orderId', $orderId, PDO::PARAM_STR);
        $stmt->execute();

        $sanitizedArray = $this->Functions->sanitizeArray($stmt->fetch(PDO::FETCH_ASSOC));

        return $sanitizedArray['status'];
    }

}
