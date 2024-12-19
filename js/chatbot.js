document.addEventListener('DOMContentLoaded', function () {
    loadBotResponses();
    const container = document.querySelector('.container');
    container.style.display = 'none';
    displayInitialBotMessage();
    displayMainChoices();
});

document.getElementById('helpButton').addEventListener('click', function () {
    const container = document.querySelector('.container');
    if (container.style.display === 'block' || container.style.display === '') {
        container.style.animation = 'breatheIn 0.5s forwards';
        setTimeout(() => container.style.display = 'none', 500);
    } else {
        container.style.display = 'block';
        container.style.animation = 'breatheOut 0.5s forwards';
    }
});

document.getElementById('clearChat').addEventListener('click', function () {
    const allMessages = document.querySelectorAll(".ContentChat .massage, .ContentChat .name-tag, .ContentChat .chat-bubble");
    let isFirstBotMessageKept = false;

    allMessages.forEach(function (message) {
        if (!isFirstBotMessageKept && message.classList.contains('bot-response')) {
            isFirstBotMessageKept = true;
        } else {
            message.remove();
        }
    });
});

document.querySelector('.send-button').addEventListener('click', sendUserMessage);
document.querySelector('.InputMSG').addEventListener('keydown', function (event) {
    if (event.key === 'Enter' || event.keyCode === 13) {
        event.preventDefault();
        sendUserMessage();
    }
});