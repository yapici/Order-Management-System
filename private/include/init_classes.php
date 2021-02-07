<?php
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
$ItemDetails = new ItemDetails($Database, $Functions, $Vendors, $Email, $Admin);

/** @var Orders $Orders */
$Orders = new Orders($Database, $Functions, $Admin);

/** @var Projects $Projects */
$Projects = new Projects($Database, $Functions);

/** @var Users $Users */
$Users = new Users($Database, $Functions);

/** @var Purchasers $Purchasers */
$Purchasers = new Purchasers($Database, $Functions);

