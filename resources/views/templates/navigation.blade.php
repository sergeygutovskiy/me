<nav class="navigation">
    <ul class="navigation__content navigation__content_media_pc">
        <li class="navigation__item navigation__title">
            <a @if ($route !== '/') href="/" @endif>
                Главная
            </a>
        </li>
        <li class="navigation__item">
            <a  @if ($route !== '/for-developers') href="/for-developers" @endif>
                Для разработчиков
            </a>
        </li>
        <li class="navigation__item">
            <a  @if ($route !== '/notes') href="/notes" @endif>
                Заметки
            </a>
        </li>
        <li class="navigation__item">
            <a  @if ($route !== '/portfolio') href="/portfolio" @endif>
                Портфолио
            </a>
        </li>
    </ul>
    <div class="navigation__content navigation__content_media_mobile">
        <a 
            class="navigation__item navigation__title" 
            @if ($route !== '/') href="/" @endif
            >
            Главная
        </a>
        <a 
            class="navigation__icon icon icon_for-developers" 
            @if ($route !== '/for-developers') href="/for-developers" @endif
            >
        </a>
        <a 
            class="navigation__icon icon icon_note" 
            @if ($route !== '/notes') href="/notes" @endif
            >
        </a>
        <a 
            class="navigation__icon icon icon_portfolio" 
            @if ($route !== '/portfolio') href="/portfolio" @endif
            >
        </a>
    </ul>
</nav>