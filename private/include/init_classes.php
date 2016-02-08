<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/31/2015                                                                 */
/* Last modified on 02/07/2016                                                           */
/* ===================================================================================== */

/* ===================================================================================== */
/* The MIT License                                                                       */
/*                                                                                       */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>.                                 */
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

/** @var Session $Session */
$Session = new Session();

/** @var Functions $Functions */
$Functions = new Functions();

/** @var Email $Email */
$Email = new Email();

/** @var Admin $Admin */
$Admin = new Admin($Session);

/** @var Vendors $Vendors */
$Vendors = new Vendors($Database, $Functions, $Admin);

/** @var CostCenters $CostCenters */
$CostCenters = new CostCenters($Database, $Functions);

/** @var ItemDetails $ItemDetails */
$ItemDetails = new ItemDetails($Database, $Functions, $Vendors, $Email);

/** @var Orders $Orders */
$Orders = new Orders($Database, $Functions, $Admin);

/** @var Projects $Projects */
$Projects = new Projects($Database, $Functions);

/** @var Users $Users */
$Users = new Users($Database, $Functions);

/** @var Purchasers $Purchasers */
$Purchasers = new Purchasers($Database, $Functions);

