<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 11.07.2018
 * Time: 14:02
 */

?>

<object id="logo" type="image/svg+xml" data="/img/logo_white.svg"></object>
<form id="form-login">
    <label class="phone">
        <span class='flag flag-ru'></span>
        <input type="text" autofocus="autofocus" tabindex="1" name="phone" id="phone-input" placeholder="+7"><svg class="tick-svg" viewBox="-10 -10 512 512"><use xlink:href="#tick-svg"></use></svg>
        <p class="error-msg">Неверный номер</p>
    </label>
    <label class="password hidden"><input type="password" id="password-input" name="password"><span>Пароль</span><svg class="error-msg" viewBox="0 0 180 52"><use xlink:href="#msg-err"></use></svg><p class="error-msg">Неверный пароль</p></label>
    <label class="name hidden"><input type="text" id="name-input" name="name"><span>Имя</span><svg class="error-msg" viewBox="0 0 180 52"><use xlink:href="#msg-err"></use></svg><p class="error-msg">Нужно заполнить имя</p></label>
    <label class="sms hidden"><p class="txt">Мы выслали код подтверждения.</p><p class="new hidden">Ничего не пришло? <span id="send-new" class="dlink">Выслать снова.</span></p><input type="text" id="sms-code" name="sms" size="13"></label>
    <div class="type-p hidden">
        <label class="type"><input type="radio" name="type" value="object"><span>У меня есть площадь</span></label>
        <label class="type"><input type="radio" name="type" value="search"><span>Я ищу площадь</span></label>
        <svg class="error-msg" viewBox="0 0 180 52"><use xlink:href="#msg-err"></use></svg>
        <p class="error-msg">Нужно выбрать</p>
    </div>
    <button type="button" class="hidden" id="enter">Войти</button>
    <p class="new-pass hidden">Забыли пароль? <span id="send-new-pass" class="dlink">Прислать новый.</span></p>
    <button type="button" class="hidden" id="next">Дальше</button>
    <button type="button" class="hidden" id="send">Выслать код</button>
    <p id="new-send-success" class="hidden">Новый код выслан</p>
    <p class="hidden" id="confirm">Нажимая кнопку вы соглашаетесь с условиями
        <a target="_blank" class="def-link" href="/user-agreement">пользовательского соглашения</a> и <a target="_blank"  class="def-link" href="/privacy-policy">политикой конфиденциальности</a></p>
</form>
