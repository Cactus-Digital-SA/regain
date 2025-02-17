<div class="live-chat-bubble">
    <div class="live-chat-message d-flex flex-column align-items-center">
        <button type="button" class="live-chat-icon-container">
            <img src="{{Vite::asset('resources/images/live-chat.svg')}}" alt="Chat" class="live-chat-icon">
        </button>
        <span class="live-chat-text">Live Chat</span>
    </div>
</div>

<div class="live-chat-container">
    <img src="{{Vite::asset('resources/images/live-chat-image.png')}}" alt="Chat" class="live-chat-mock">
</div>


<style>
    .live-chat-bubble {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }

    .live-chat-container {
        display: none;
        z-index: 1000;
        position: fixed;
        bottom: 110px;
        right: 20px;
    }

    .live-chat-mock {
        width: 266px;
        height: 400px;
    }

    .live-chat-message {
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        border: none;
    }

    .live-chat-icon-container {
        width: 60px;
        height: 60px;
        background: rgba(146, 161, 237, 1);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        border: none;
    }

    .live-chat-icon-container:hover {
        background: rgb(108, 119, 175);
    }

    .live-chat-icon-container:active {
        background: rgb(135, 151, 218);
        transform: scale(1.1);
    }

    .live-chat-icon {
        width: 30px;
        height: 30px;
    }

    .live-chat-text {
        color: rgba(39, 52, 61, 1);
        font-weight: 700;
        font-size: 13px;
        line-height: 25px;
        letter-spacing: 0;
        text-align: center;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const chatButton = document.querySelector(".live-chat-icon-container");
        const chatContainer = document.querySelector(".live-chat-container");

        chatButton.addEventListener("click", function () {
            if (chatContainer.style.display === "none" || chatContainer.style.display === "") {
                chatContainer.style.display = "block";
            } else {
                chatContainer.style.display = "none";
            }
        });
    });
</script>
