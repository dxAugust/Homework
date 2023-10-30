<?php
print(include_template('header.php', [
    'page_title' => 'Главная',
]));
?>

    <main class="container">
        <?= $main ?>
    </main>
</div>

<?php
print(include_template('footer.php', [
    'categories' => $categories,
]));
?>