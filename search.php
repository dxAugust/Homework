<?php
    require_once('init.php');

    $category_list = get_categories_list($mysql);
    $search_term = $_GET["search"];

    $current_page = 1;

    isset($_GET["page"]) ? $current_page = $_GET["page"] : "";
    $max_pages = 0;

    $lots = search_lots_by_name($mysql, $search_term);

    print(include_template('header.php', [
      'page_title' => $page_title,
      'categories' => $category_list
    ]));

    print(include_template('search.php', [
      'search_term' => $search_term,
      'lots' => $lots,
      'current_page' => $current_page,
      'max_pages' => $max_pages,
    ]));
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => $category_list,
]));

?>