<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/13/2015                                                                 */
/* Last modified on 01/03/2016                                                           */
/* ===================================================================================== */

/* ===================================================================================== */
/* The MIT License                                                                       */
/*                                                                                       */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>.                                 */
/*                                                                                       */
/* Permission is hereby granted, free of charge, to any person obtaining a copy          */
/* of this software and associated documentation files (the "Software"), to deal         */
/* in the Software without restriction, including without limitation the rights          */
/* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell             */
/* copies of the Software, and to permit persons to whom the Software is                 */
/* furnished to do so, subject to the following conditions:                              */
/*                                                                                       */
/* The above copyright notice and this permission notice shall be included in            */
/* all copies or substantial portions of the Software.                                   */
/*                                                                                       */
/* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR            */
/* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,              */
/* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE           */
/* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER                */
/* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,         */
/* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN             */
/* THE SOFTWARE.                                                                         */
/* ===================================================================================== */

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
    const DOMAIN_NAME = 'oms.petchum.com';
    const DOMAIN_NAME_HTTP = 'http://oms.petchum.com';

    private function __construct() {
        throw new Exception("Can't get an instance of Constants");
    }

}
