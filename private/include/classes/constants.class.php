<?php
final class Constants {

    // Database details
    const DB_SERVER = 'localhost';
    const DB_USER = 'oms_user';
    const DB_PASS = 'ka8*Q5(8Tku.hBs';
    const DB_NAME = 'oms_database';
    
    // User types
    const USER_TYPE_END_USER = 0;
    const USER_TYPE_PURCHASING_PERSON = 1;
    const USER_TYPE_ADMINISTRATOR = 2;
    
    // Order status
    const ORDER_STATUS_PENDING = 'Pending';
    const ORDER_STATUS_PROCESSING = 'Processing';
    const ORDER_STATUS_ORDERED = 'Ordered';
    const ORDER_STATUS_DELIVERED = 'Delivered';
    const ORDER_STATUS_BACKORDERED = 'Backordered';
    
    // Item ordered status
    const ORDER_PLACED = 1;
    
    // Domain name
    const DOMAIN_NAME = 'www.example.com';
    const DOMAIN_NAME_HTTP = 'http://www.example.com';
    const DOMAIN_EMAIL_EXT = 'example.com';
    
    // Webmaster E-mail
    const WEBMASTER_EMAIL = 'engin.yapici@example.com';

    private function __construct() {
        throw new Exception("Can't get an instance of Constants");
    }

}