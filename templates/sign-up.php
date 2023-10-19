<form class="form container <?php if (!empty(array_filter($error_codes, 'strlen'))): ?>form--invalid<?php endif; ?>" action="../sign-up.php" method="post" autocomplete="off">
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item <?php if ($error_codes["email"]): ?> form__item--invalid <?php endif; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" value="<?= htmlspecialchars(get_post_val("email")) ?>" placeholder="Введите e-mail">
        <span class="form__error">Введите e-mail</span>
      </div>
      <div class="form__item <?php if ($error_codes["password"]): ?> form__item--invalid <?php endif; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" value="<?= htmlspecialchars(get_post_val("password")) ?>" placeholder="Введите пароль">
        <span class="form__error">Введите пароль</span>
      </div>
      <div class="form__item <?php if ($error_codes["name"]): ?> form__item--invalid <?php endif; ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" value="<?= htmlspecialchars(get_post_val("name")) ?>" placeholder="Введите имя">
        <span class="form__error">Введите имя</span>
      </div>
      <div class="form__item <?php if ($error_codes["message"]): ?> form__item--invalid <?php endif; ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться" value="<?= htmlspecialchars(get_post_val("message")) ?>"></textarea>
        <span class="form__error">Напишите как с вами связаться</span>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="../login.php">Уже есть аккаунт</a>
</form>