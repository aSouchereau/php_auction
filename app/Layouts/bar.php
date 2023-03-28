<?php

use App\Exceptions\ClassException;
use App\Lib\Logger;
use App\Models\Category;

// Retrieve all categories as objects
try {
    $catObjs = Category::all('cat');
} catch (ClassException $e) {
    Logger::getLogger()->critical("No results returned: ", ["exception => $e"]);
    echo "No results returned";
    die();
}

?>

<h1>Categories</h1>
<ul>
    <li>
        <a href="index.php">View All</a>
    </li>
        <?php
        // Iterates through each category object and outputs name
        /* @var $catObjs \App\Models\Category */
        foreach ($catObjs as $catObj) : ?>
        <li>
            <a href='index.php?id=<?php echo $catObj->get('id') ?>'>
                <?php echo $catObj->get('cat') ?>
            </a>
        </li>
        <?php endforeach; ?>

</ul>
