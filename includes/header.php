<?php
    echo "<div id='header' class='header'>";
    echo '
    <ul class="navbar_container_ul" id="navbar_container">
        <li id="home_button_li" class="left"><a href="/pages/home.php" class="navbar_button">Home</a></li>
        <li id="search_button_li" class="left"><a href="/pages/search.php" class="navbar_button">Search</a></li>
        <li id="add_button_li" class="left"><a href="/pages/add.php" class="navbar_button">Add Entry</a></li>
        <li id="tags_button_li" class="left"><a href="/pages/tags.php" class="navbar_button">Tags</a></li>
        <li id="logout_button_li" class="right"><a href="/pages/logout.php" class="navbar_button">Lougout</a></li>
    ';
    echo "</ul>";
    echo "</div>";
?>