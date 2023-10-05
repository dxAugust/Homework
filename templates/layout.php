<?php
print(include_template('header.php', [
    'page_title' => 'Главная',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories,
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