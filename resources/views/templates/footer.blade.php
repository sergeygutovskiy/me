<?php use App\Core\Settings; ?>

<footer class="footer">
    <div class="footer__content">
        <a class="footer__link footer__email" href="mailto:{{ Settings::get('email') }}">
            {{ Settings::get('email') }}
        </a>

        <a 
            class="footer__link icon icon_vk" 
            href="{{ Settings::get('link_vk') }}"></a>
        <a 
            class="footer__link icon icon_github" 
            href="{{ Settings::get('link_github') }}"></a>
        <a 
            class="footer__link icon icon_inst" 
            href="{{ Settings::get('link_inst') }}"></a>
    </div>
</footer>

<script src="/js/app.js"></script>