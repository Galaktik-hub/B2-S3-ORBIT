document.addEventListener('DOMContentLoaded', function () {
    loadBotResponses();
    const container = document.querySelector('.container');
    container.classList.add('hidden'); 
    if (!localStorage.getItem('initialMessageDisplayed')) {
        displayInitialBotMessage();
        localStorage.setItem('initialMessageDisplayed', 'true');
    }
    displayMainChoices();
    getUserId(); 
});

document.getElementById('helpButton').addEventListener('click', function () {
    const container = document.querySelector('.container');
    if (container.classList.contains('hidden')) {
        container.classList.remove('hidden');
        container.classList.add('visible');
    } else {
        container.classList.remove('visible');
        container.classList.add('hidden');
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

document.getElementById('showKeywords').addEventListener('click', displayKeywords);

document.querySelector('.send-button').addEventListener('click', sendUserMessage);
document.querySelector('.InputMSG').addEventListener('keydown', function (event) {
    if (event.key === 'Enter' || event.keyCode === 13) {
        event.preventDefault();
        sendUserMessage();
    }
});

function displayInitialBotMessage() {
    addBotMessage("Salut ! Que puis-je faire pour vous ?");
}

function displayMainChoices() {
    displayChoiceButtons(["a", "b"]);
}

function displayChoiceButtons(choices, showBackButton = false) {
    const buttonsContainer = document.getElementById('choiceButtons');
    buttonsContainer.innerHTML = '';

    choices.forEach(choice => {
        const button = document.createElement('button');
        button.textContent = choice;
        button.addEventListener('click', () => handleChoiceClick(choice));
        buttonsContainer.appendChild(button);
    });

    if (showBackButton) {
        const backButton = document.createElement('button');
        backButton.textContent = "Revenir";
        backButton.classList.add('back-button');
        backButton.addEventListener('click', displayMainChoices);
        buttonsContainer.appendChild(backButton);
    }
}

function handleChoiceClick(choice) {
    switch (choice) {
        case "test":
            displayChoiceButtons(["test"], true);
            break;
        default:
            handleSubChoice(choice);
    }
}

function handleSubChoice(choice) {
    addChatBubble("<b>Choix: </b>" + choice, "user");

    const responses = {
        "test": "test",
        default: "Je ne suis pas sûr de comprendre. Utilisez des mots-clés pour que je puisse comprendre plus facilement votre demande."
    };

    const response = responses[choice] || responses.default;
    const responseElement = document.getElementById('activeColor');
    responseElement.classList.remove('wrong');
    addBotMessage(response);
}

function addChatBubble(message, sender) {
    const contentChat = document.querySelector('.ContentChat');
    const bubble = document.createElement('div');
    bubble.classList.add("chat-bubble", sender);
    bubble.innerHTML = `<div class="text fadeIn">${message}</div>`;

    const nameTag = document.createElement('div');
    nameTag.classList.add("name-tag", sender === "user" ? "name-user" : "name-bot", "fadeIn");
    nameTag.textContent = sender === "user" ? "Vous" : "OX-1";

    contentChat.appendChild(bubble);
    contentChat.appendChild(nameTag);
    nameTag.scrollIntoView({ behavior: "smooth" });
}

function addBotMessage(message) {
    const activeColor = document.getElementById('activeColor');
    const contentChat = document.getElementsByClassName("ContentChat")[0];
    activeColor.classList.add('neutre');

    const loader = document.createElement("div");
    loader.classList.add("loader");
    for (let i = 0; i < 3; i++) {
        const dot = document.createElement("div");
        dot.classList.add("loader-dot");
        loader.appendChild(dot);
    }
    contentChat.appendChild(loader);

    setTimeout(function () {
        loader.remove();
        const bubbleContainer = document.createElement('div');
        bubbleContainer.classList.add("bubble-container", "bot");

        const elementMSG = document.createElement("div");
        elementMSG.classList.add("massage", "bot-response");
        elementMSG.innerHTML = `<img src="../images/droid.png" alt="OX-1" class="bot-avatar"><div class="text">${message}</div>`;
        bubbleContainer.appendChild(elementMSG);

        const botNameTag = document.createElement('div');
        botNameTag.classList.add("name-tag", "name-bot", "fadeIn");
        botNameTag.textContent = "OX-1";
        bubbleContainer.appendChild(botNameTag);

        contentChat.appendChild(bubbleContainer);
        bubbleContainer.scrollIntoView({ behavior: "smooth" });
        activeColor.classList.remove('neutre');
    }, 2000);
}

function generateUniqueId() {
    return 'xxxx-xxxx-4xxx-yxxx-xxxx'.replace(/[xy]/g, function (c) {
        const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

function getUserId() {
    let userId = localStorage.getItem('userId');
    if (!userId) {
        userId = generateUniqueId();
        localStorage.setItem('userId', userId);
    }
    return userId;
}

async function logUnansweredQuestion(question) {
    const userId = getUserId();
    try {
        const response = await fetch('http://localhost:3000/log', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ userId, question }),
        });
        if (!response.ok) {
            console.error('Failed to log question');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function isAuthenticated() {
    const authTimestamp = localStorage.getItem('authTimestamp');
    if (!authTimestamp) return false;

    const currentTime = Date.now();
    const elapsedTime = currentTime - parseInt(authTimestamp, 10);

    return elapsedTime < 10 * 60 * 1000;
}

function authenticateUser() {
    const currentTime = Date.now();
    const failedAttempts = JSON.parse(localStorage.getItem('failedAttempts')) || { count: 0, timestamp: currentTime };

    if (failedAttempts.count >= 5 && (currentTime - failedAttempts.timestamp) < 10 * 60 * 1000) {
        const blockTime = 10 * 60 * 1000; 
        const timeSinceLastAttempt = currentTime - failedAttempts.timestamp;

        if (timeSinceLastAttempt < blockTime) {
            alert(`Vous ne pouvez plus utiliser de commande pendant ${Math.ceil((blockTime - timeSinceLastAttempt) / 1000)} secondes.`);
            return false;
        }

        failedAttempts.count = 0;
        localStorage.setItem('failedAttempts', JSON.stringify(failedAttempts));
    }

    const password = prompt("Entrez le mot de passe :");
    if (password === "") {
        localStorage.setItem('authTimestamp', Date.now().toString());
        failedAttempts.count = 0;
        localStorage.setItem('failedAttempts', JSON.stringify(failedAttempts));
        return true;
    } else {
        failedAttempts.count += 1;
        failedAttempts.timestamp = currentTime;
        localStorage.setItem('failedAttempts', JSON.stringify(failedAttempts));
        alert("Mauvais Mot de passe.");
        return false;
    }
}

function displayHelpMessage() {
    const helpMessage = `
    <table><thead><tr><th>Commande + format</th><th>Utilité</th></tr></thead><tbody>
        <tr><td><b>/learn [mots-clés] : [réponse]</b></td><td>Apprend un nouveau mot-clé et une réponse correspondante.</td></tr>
        <tr><td><b>/del [mot-clé]</b></td><td>Supprime un mot-clé existant.</td></tr>
        <tr><td><b>/keyword-modify [ancien mot-clé] : [nouveau mot-clé]</b></td><td>Modifie un mot-clé existant.</td></tr>
        <tr><td><b>/response-modify [mot-clé] : [nouvelle réponse] </b></td><td>Modifie la réponse associée à un mot-clé.</td></tr>
        <tr><td><b>/liste</b></td><td>Affiche touts les mot clées et réponses disponibles.</td></tr>
        <tr><td><b>/alldel</b></td><td>Supprime toutes les réponses apprises.</td></tr>
        <tr><td><b>/help</b></td><td>Affiche ce message d'aide.</td></tr>
    </tbody></table>
    `;
    addBotMessage(helpMessage);
}

function sendUserMessage() {
    const inputField = document.querySelector('.InputMSG');
    const userInput = inputField.value.trim();
    const activeColor = document.getElementById('activeColor');

    if (!userInput) {
        return;
    }

    addChatBubble(userInput, "user");

    if (userInput.startsWith("/")) {
        if (!isAuthenticated() && !authenticateUser()) {
            return;
        }

        const command = userInput.split(' ')[0];
        const args = userInput.split(' ').slice(1).join(' ');

        if (command === '/help') {
            displayHelpMessage();
        } else if (command === '/learn') {
            const [keywords, response] = args.split(':').map(part => part.trim());
            if (keywords && response) {
                addNewBotResponse(keywords, response);
            } else {
                addBotMessage("Format incorrect. Utilisez /learn [mots-clés] : [réponse]");
            }
        } else if (command === '/del') {
            const keyword = args.trim();
            if (keyword) {
                removeKeyword(keyword);
            } else {
                addBotMessage("Format incorrect. Utilisez /del [mot-clé]");
            }
        } else if (command === '/liste') {
            const botResponsesList = listBotResponses();
            addBotMessage(botResponsesList);
        } else if (command === '/keyword-modify') {
            const [oldKeyword, newKeyword] = args.split(':').map(part => part.trim());
            if (oldKeyword && newKeyword) {
                modifyKeyword(oldKeyword, newKeyword);
            } else {
                addBotMessage("Format incorrect. Utilisez /keyword-modify [ancien mot-clé] : [nouveau mot-clé]");
            }
        } else if (command === '/response-modify') {
            const [keyword, newResponse] = args.split(':').map(part => part.trim());
            if (keyword && newResponse) {
                modifyResponse(keyword, newResponse);
            } else {
                addBotMessage("Format incorrect. Utilisez /response-modify [mot-clé] : [nouvelle réponse]");
            }
        } else if (command === '/alldel') {
            deleteAllResponses();
        } else {
            addBotMessage('Commande non reconnue.');
        }
    } else {
        const matchedChoice = findBestBotResponse(userInput);
        const highSimilarityThreshold = 0.8;
        const command2 = userInput.split(' ')[0];
        if (matchedChoice && matchedChoice.score >= highSimilarityThreshold) {
            addBotMessage(matchedChoice.response);
            activeColor.classList.remove('wrong');
        } else if (matchedChoice) {
            askForConfirmation(matchedChoice.keyword, matchedChoice.response);
            activeColor.classList.remove('wrong');
        } else if (command2 === 'aide' || command2 === 'help') {
            const botResponsesList = listBotResponsesForUser();
            addBotMessage(botResponsesList);
        } else {
            addBotMessage('Je ne suis pas sûr de comprendre. Utilisez des mots-clés pour que je puisse comprendre plus facilement votre demande.');
            activeColor.classList.add('wrong');
            logUnansweredQuestion(userInput);
        }
    }

    inputField.value = '';
}

function displayKeywords() {
    let keywordsMessage = "Pas de soucis ! Afin de pouvoir vous aider au maximum, je peux vous parler de :<br><br>";
    const uniqueKeywords = new Set();
    addChatBubble("J'ai besoin d'aide", "user");

    for (const choice in botResponses) {
        const { keywords } = botResponses[choice];
        keywords.forEach(keyword => uniqueKeywords.add(keyword));
    }

    keywordsMessage += "<div class='keywords-grid'>";

    uniqueKeywords.forEach(keyword => {
        keywordsMessage += `<div class='keyword-item'>- ${keyword}</div>`;
    });

    keywordsMessage += "</div><br> Vous n'avez qu'à écrire l'un des mots ci-dessus.";

    addBotMessage(keywordsMessage);
}



function askForConfirmation(keyword, response) {
    const confirmationMessage = `Voulez-vous que je vous parle de "${keyword}" ?`;
    const activeColor = document.getElementById('activeColor');
    addBotMessage(confirmationMessage);

    const inputField = document.querySelector('.InputMSG');
    const choicebutton = document.querySelector('.choice-buttons');
    const sendButton = document.querySelector('.send-button');
    const inputContainer = document.querySelector('.BoxSentMSG');
    inputField.style.display = 'none';
    sendButton.style.display = 'none';
    choicebutton.style.display = 'none';

    const buttonsContainer = document.createElement('div');
    buttonsContainer.classList.add('confirmation-buttons');

    const yesButton = document.createElement('button');
    yesButton.textContent = 'Oui';
    yesButton.addEventListener('click', () => {
        addChatBubble("Oui", "user");
        addBotMessage(response);
        inputField.style.display = 'inline-block';
        sendButton.style.display = 'inline-block';
        choicebutton.style.display = 'grid';
        removeConfirmationButtons();
        activeColor.classList.remove("wrong");
    });

    const noButton = document.createElement('button');
    noButton.textContent = 'Non';
    noButton.addEventListener('click', () => {
        addChatBubble("Non", "user");
        addBotMessage("Merci de reformuler, je n'ai pas compris votre question.");
        inputField.style.display = 'inline-block';
        sendButton.style.display = 'inline-block';
        choicebutton.style.display = 'grid';
        removeConfirmationButtons();
        activeColor.classList.add("wrong");
    });

    buttonsContainer.appendChild(yesButton);
    buttonsContainer.appendChild(noButton);

    inputContainer.appendChild(buttonsContainer);
}

function removeConfirmationButtons() {
    const buttonsContainer = document.querySelector('.confirmation-buttons');
    if (buttonsContainer) {
        buttonsContainer.remove();
    }
}