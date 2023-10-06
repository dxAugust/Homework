<form class="form container<?php if(!empty(array_filter($error_codes, 'strlen'))): ?> form--invalid <?php endif; ?>" action="../login.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>
      <div class="form__item <?php if ($error_codes["email"]): ?> form__item--invalid <?php endif; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" value="<?= htmlspecialchars(getPostVal("email")) ?>" placeholder="Введите e-mail">
        <span class="form__error"><?= $error_codes["email"] ?></span>
      </div>
      <div class="form__item form__item--last <?php if ($error_codes["password"]): ?> form__item--invalid <?php endif; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" value="<?= htmlspecialchars(getPostVal("password")) ?>" placeholder="Введите пароль">
        <span class="form__error"><?= $error_codes["password"] ?></span>
      </div>

      <span class="form__error form__error--bottom"><?= $auth_error ?></span>
      <button type="submit" class="button">Войти</button>
    </form>
  </main>