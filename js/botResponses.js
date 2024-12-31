const initialBotResponses = {
    "Voyage": {
        "response": "Pour réserver un voyage, rendez-vous sur la page <a href='../page/travel_form.php'>Réservation de voyage</a>. Vous pouvez y choisir votre destination, votre moyen de transport et définir vos préférences.",
        "keywords": ["réserver", "planifier", "voyager", "réservation", "trajet"]
    },
};

function levenshtein(a, b) {
    const matrix = [];

    for (let i = 0; i <= b.length; i++) {
        matrix[i] = [i];
    }

    for (let j = 0; j <= a.length; j++) {
        matrix[0][j] = j;
    }

    for (let i = 1; i <= b.length; i++) {
        for (let j = 1; j <= a.length; j++) {
            if (b.charAt(i - 1) === a.charAt(j - 1)) {
                matrix[i][j] = matrix[i - 1][j - 1];
            } else {
                matrix[i][j] = Math.min(
                    matrix[i - 1][j - 1] + 1,
                    matrix[i][j - 1] + 1,
                    matrix[i - 1][j] + 1
                );
            }
        }
    }

    return matrix[b.length][a.length];
}

function getSimilarity(a, b) {
    const maxLength = Math.max(a.length, b.length);
    if (maxLength === 0) {
        return 1.0;
    }
    return (maxLength - levenshtein(a, b)) / maxLength;
}


const botResponses = { ...initialBotResponses };

function findBestBotResponse(userInput) {
    const inputWords = userInput.toLowerCase().split(/\s+/);
    let bestMatch = { score: 0, keyword: null, response: null };

    for (const choice in botResponses) {
        const { keywords, response } = botResponses[choice];

        for (const keyword of keywords) {
            for (const word of inputWords) {
                const similarity = getSimilarity(word, keyword.toLowerCase());
                if (similarity > bestMatch.score) {
                    bestMatch = { score: similarity, keyword: keyword, response: response };
                }
            }
        }
    }

    const similarityThreshold = 0.5; // Adjust the threshold as needed
    return bestMatch.score >= similarityThreshold ? bestMatch : null;
}

function keywordExists(keyword) {
    keyword = keyword.trim().toLowerCase();
    for (const key in botResponses) {
        if (botResponses[key].keywords.includes(keyword)) {
            return true;
        }
    }
    return false;
}

function addNewBotResponse(keywords, response) {
    const keywordsArray = keywords.split(',').map(kw => kw.trim().toLowerCase());
    if (keywordsArray.some(keywordExists)) {
        addBotMessage(`Le mot-clé "${keywordsArray.find(keywordExists)}" existe déjà. Utilisez des mots-clés uniques.`);
        return;
    }

    const newResponse = {
        response: response,
        keywords: keywordsArray
    };

    botResponses[response] = newResponse;
    saveBotResponses();
    addBotMessage("Nouvelle réponse ajoutée avec succès !");
}

function removeKeyword(keyword) {
    keyword = keyword.trim().toLowerCase();
    let keywordFound = false;

    for (const key in botResponses) {
        const response = botResponses[key];
        const index = response.keywords.indexOf(keyword);
        if (index !== -1) {
            response.keywords.splice(index, 1);
            keywordFound = true;
            if (response.keywords.length === 0) {
                delete botResponses[key];
            }
            break;
        }
    }

    if (keywordFound) {
        saveBotResponses();
        addBotMessage(`Mot-clé "${keyword}" supprimé avec succès.`);
    } else {
        addBotMessage(`Mot-clé "${keyword}" introuvable.`);
    }
}

function saveBotResponses() {
    localStorage.setItem('botResponses', JSON.stringify(botResponses));
}

function loadBotResponses() {
    const storedResponses = localStorage.getItem('botResponses');
    if (storedResponses) {
        Object.assign(botResponses, JSON.parse(storedResponses));
    } else {
        Object.assign(botResponses, initialBotResponses);
    }
}

function modifyKeyword(oldKeyword, newKeyword) {
    oldKeyword = oldKeyword.trim().toLowerCase();
    newKeyword = newKeyword.trim().toLowerCase();
    let keywordFound = false;

    for (const key in botResponses) {
        const response = botResponses[key];
        const index = response.keywords.indexOf(oldKeyword);
        if (index !== -1) {
            response.keywords[index] = newKeyword; 
            keywordFound = true;
            break;
        }
    }

    if (keywordFound) {
        saveBotResponses();
        addBotMessage(`Mot-clé "${oldKeyword}" modifié en "${newKeyword}" avec succès.`);
    } else {
        addBotMessage(`Mot-clé "${oldKeyword}" introuvable.`);
    }
}

function modifyResponse(keyword, newResponse) {
    keyword = keyword.trim().toLowerCase();
    let keywordFound = false;

    for (const key in botResponses) {
        const response = botResponses[key];
        if (response.keywords.includes(keyword)) {
            botResponses[key].response = newResponse;
            keywordFound = true;
            break;
        }
    }

    if (keywordFound) {
        saveBotResponses();
        addBotMessage(`Réponse pour le mot-clé "${keyword}" modifiée avec succès.`);
    } else {
        addBotMessage(`Mot-clé "${keyword}" introuvable.`);
    }
}

function listBotResponses() {
    let responseMessage = "<table><thead><tr><th>Mots-Clés</th><th>Réponse</th></tr></thead><tbody>";

    for (const key in botResponses) {
        const keywords = botResponses[key].keywords.join(', ');
        const response = botResponses[key].response;
        responseMessage += `<tr><td>${keywords}</td><td>${response}</td></tr>`;
    }

    responseMessage += "</tbody></table>";
    return responseMessage;
}

function listBotResponsesForUser() {
    let responseMessage = "<table><thead><tr><th>Informations</th></tr></thead><tbody>";

    for (const key in botResponses) {
        const response = botResponses[key].response;
        responseMessage += `<tr><td>${response}</td></tr>`;
    }

    responseMessage += "</tbody></table>";
    return responseMessage;
}

function deleteAllResponses() {
    Object.keys(botResponses).forEach(key => {
        delete botResponses[key];
    });
    Object.assign(botResponses, initialBotResponses);
    saveBotResponses();
    addBotMessage("Toutes les réponses ont été supprimées avec succès.");
}