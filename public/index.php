<?php

use App\Models\Item;

require_once(__DIR__ . '/../app/bootstrap.php');

if(isset($_GET['id'])) {
    $validid = pf_validate_number($_GET['id'],"value", CONFIG_URL);
} else {
    $validid = 0;
}


require(__DIR__ . '/../app/Layouts/header.php');

if ($validid == 0) {
    $items = Item::find("date > NOW()");
} else {
    $items = Item::find("date > NOW() AND cat_id = $validid");
}

?>

<h1>Items Available</h1>
<table cellpadding='5'>
    <tr>
        <th>Image</th>
        <th>Item</th>
        <th>Bids</th>
        <th>Price</th>
        <th>End Date for this Item</th>
    </tr>
<?php
if(!$items) {
    echo "<tr><td colspan=4>No Items!</td></tr>";
} else {
    foreach ($items as $item) {
        echo "<tr>";
        // Load image objects into item
        $item->getImages();
        // If there are no images, alert user
        if(!$item->get('imageObjs')) {
            echo "<td>No Image</td>";
        } else {
            // Return only the first image obj from the array
            $img = $item->get('imageObjs');
            $firstImage = array_shift($img);
            echo "<td><img src='imgs/" . $firstImage->get('name') . "' width='100'></td>";
        }

        // Load name of item
        echo "<td>";
        echo "<a href='itemdetails.php?id={$item->get('id')}'>{$item->get('name')}</a>";
        echo "</td>";

        echo "<td>";
        // Load bid objects into item
        $item->getBids();
        // If there are no bid objects, alert user
        if (!$item->get('bidObjs')) {
            echo "0";
        } else {
            // display number of bids
            echo count($item->get('bidObjs'));
        }
        echo "</td>";

        echo "<td>" . CONFIG_CURRENCY;
        // if there are no bids for the item, display starting price, otherwise display the highest bid
        if (!count($item->get('bidObjs'))) {
            echo sprintf('%.2f', $item->get('price'));
        } else {
            $itemBids = $item->get('bidObjs');
            $highestBid = array_shift($itemBids);
            echo sprintf('%.2f', $highestBid->get('amount'));
        }
        echo "</td>";

        echo "<td>" . date("D jS F Y g.iA", strtotime($item->get('date'))) . "</td>";
        echo "</tr>";
    }
}

echo "</table>";

require(__DIR__ . '/../app/Layouts/footer.php');
