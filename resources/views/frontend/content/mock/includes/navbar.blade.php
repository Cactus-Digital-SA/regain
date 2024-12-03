<div class="header">
    <div class="logo">
        <img src="{{ Vite::asset('resources/images/logo/regain-logo.svg') }}" alt="Regain Logo" class="logo-image">
    </div>
    <div class="menu">
        <a href="#">Regain</a>
        <a href="#">My Regain</a>
        <a href="#">Community</a>
        <a href="#">Help</a>
    </div>
    <div class="language-toggle">
        <div class="language-letters" style="cursor: pointer">UKR | <strong>ENG</strong> | RUS</div>
        <div class="toggle-switch" id="toggle-switch"></div>
    </div>
</div>


@vite(['resources/css/navbar-front.css', 'resources/css/front-main.css'])

<script>
    const toggleSwitch = document.getElementById('toggle-switch');
    toggleSwitch.addEventListener('click', function () {
        toggleSwitch.classList.toggle('active');
    });
</script>
