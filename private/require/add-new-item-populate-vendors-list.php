<?php
/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/15/2015                                                                 */
/* Last modified on 12/15/2015                                                           */
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

$sql = "SELECT id, name, phone, website FROM vendors WHERE approved = 1";
$stmt = $Database->prepare($sql);
$stmt->execute();

$optionsHtml = "";
$vendorDetailsHtml = "";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $sanitizedArray = $Functions->sanitizeArrayItems($row);
    $vendorId = $sanitizedArray['id'];
    $vendorName = $sanitizedArray['name'];
    $vendorPhone = $sanitizedArray['phone'];
    $vendorWebsite = $sanitizedArray['website'];

    $optionsHtml .= "<option value='$vendorId'>$vendorName</option>";
    $vendorDetailsHtml .= "<tr class='add-new-item-vendor-details-holder-tr add-new-item-vendor-details-$vendorId'>";
    $vendorDetailsHtml .= "<td>Vendor Phone:</td>";
    $vendorDetailsHtml .= "<td><span class='vendor-details-span'>$vendorPhone</span></td>";
    $vendorDetailsHtml .= "</tr>";
    $vendorDetailsHtml .= "<tr class='add-new-item-vendor-details-holder-tr add-new-item-vendor-details-$vendorId'>";
    $vendorDetailsHtml .= "<td>Vendor Website:</td>";
    $vendorDetailsHtml .= "<td><span class='vendor-details-span'>$vendorWebsite</span></td>";
    $vendorDetailsHtml .= "</tr>";
}
?>

<tr>
    <td>Vendor<span class="red-font"> *</span></td>
    <td class="add-new-item-input-holder-td">
        <select id="add-new-item-vendor" onchange="showVendorDetails(this.value);">
            <option>Please Choose a Vendor</option>
            <?php echo $optionsHtml; ?>
            <option>Add New Vendor</option>
        </select>
    </td>
</tr>
<?php echo $vendorDetailsHtml; ?>
<tr class='add-new-item-vendor-details-holder-tr add-new-item-new-vendor-details'>
    <td class='new-vendor-title-td'>Vendor Name:<span class="red-font"> *</span></td>
    <td class="add-new-item-input-holder-td">
        <input id="add-new-item-new-vendor-name" type="text"/>
    </td>
</tr>
<tr class='add-new-item-vendor-details-holder-tr add-new-item-new-vendor-details'>
    <td class='new-vendor-title-td'>Vendor Phone:<span class="red-font"> *</span></td>
    <td class="add-new-item-input-holder-td">
        <input id="add-new-item-new-vendor-phone" type="text"/>
    </td>
</tr>
<tr class='add-new-item-vendor-details-holder-tr add-new-item-new-vendor-details'>
    <td class='new-vendor-title-td'>Vendor Website:</td>
    <td class="add-new-item-input-holder-td">
        <input id="add-new-item-new-vendor-website" type="text"/>
    </td>
</tr>
<tr class='add-new-item-vendor-details-holder-tr add-new-item-new-vendor-details'>
    <td class='new-vendor-title-td'>Vendor Address:</td>
    <td class="add-new-item-input-holder-td">
        <input id="add-new-item-new-vendor-address" type="text"/>
    </td>
</tr>