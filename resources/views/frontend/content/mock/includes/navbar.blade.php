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


<style>
    body {
        background-color: #f8f8f8;
        font-family: "Inter Semi Bold", sans-serif;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    }

    .header {
        flex-shrink: 0;
        background-color: #ffffff;
        padding: 3.2rem 3.6rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 3rem;
    }

    .logo img {
        height: 60px;
        object-fit: contain;
    }

    .menu {
        display: flex;
        gap: 4.375rem;
        font-size: 16px;
    }
    .choice {
        font-size: 13px;
        font-weight: 400;
        line-height: 25px;
        text-align: center;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;
    }


    .menu a {
        text-decoration: none;
        color: #27343D;
        font-weight: 700;
    }

    .language-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
    }

    .language-toggle div {
        font-size: 14px;
    }

    .language-toggle .toggle-switch {
        display: inline-block;
        width: 48px;
        height: 24px;
        background-color: #ddd;
        border-radius: 10px;
        position: relative;
        cursor: pointer;
    }

    .language-toggle .toggle-switch:before {
        content: '';
        width: 20px;
        height: 22px;
        background-color: #ffffff;
        border-radius: 50%;
        position: absolute;
        top: 1px;
        left: 1px;
        transition: all 0.3s;
    }

    .language-toggle .toggle-switch.active:before {
        left: 28px;
        background-color: #757CA0;
    }

    .video-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
    }

    .dob-container {
        border-radius: 4rem;
        flex-direction: column;
        margin: 6.25rem auto;
        width: 100%;
        max-width: 62rem;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 30px;
        box-shadow: 0px 4px 4px 0px #00000040;

    }

    .dob-title {
        font-size: 1.4rem;
        font-weight: 600;
        line-height: 2rem;
        text-align: center;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;

    }

    .choice{
        color: #161B2C;
    }

    .btn-link{
        font-size: 16px;
        font-weight: 700;
        line-height: 19.36px;
        text-align: center;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;

        color:#27343D;
    }

    .btn-link:hover,
    .btn-link:active{
       color: #757CA0 !important;
    }

    .btn-primary {
        font-size: 16px;
        font-weight: 600;
        text-align: center;
        text-underline-position: from-font;
        text-decoration-skip-ink: none;

        width: 19rem;
        background-color: #151B2C;
        border: none;
        border-radius: 1.7rem;
        box-shadow: 0 4px 4px 0 #00000040;
        min-height: 3.4rem;
    }

    .btn-primary:hover {
        background-color: #34495e;
        transform: scale(1.02);
        transition: transform 0.3s ease-in-out;
    }

    .btn-primary:active {
        background-color: #757CA0 !important;
    }

    @media (max-width: 768px) {
        .dob-title {
            font-size: 1rem;
        }
    }
</style>

<script>
    const toggleSwitch = document.getElementById('toggle-switch');
    toggleSwitch.addEventListener('click', function () {
        toggleSwitch.classList.toggle('active');
    });
</script>
