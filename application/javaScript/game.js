document.addEventListener("DOMContentLoaded", () => {
    let currentRow = 0;
    let currentCol = 0;
    const maxRows = 6;
    const maxCols = 5;
    
    const secretWord = ""; //Mot à trouver, à voir avec Mélissa
    const startTime = Math.floor(Date.now() / 1000);
    const wordId = 1;
    const keys = document.querySelectorAll(".key");
    keys.forEach(key => {
        key.addEventListener("click", () => {
            const keyValue = key.getAttribute("data-key");
            handleKeyPress(keyValue);
        });
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            handleKeyPress("Enter");
        } else if (e.key === "Backspace") {
            handleKeyPress("Backspace");
        } else {
            const letter = e.key.toUpperCase();
            if (/^[A-Z]$/.test(letter)) {
                handleKeyPress(letter);
            }
        }
    });

    function handleKeyPress(key) {
        if (key === "Enter") {
            submitRow();
        } else if (key === "Backspace") {
            deleteLetter();
        } else {
            addLetter(key);
        }
    }

    function addLetter(letter) {
        if (currentCol < maxCols && currentRow < maxRows) {
            const tile = document.querySelector(`.tile[data-row="${currentRow}"][data-col="${currentCol}"]`);
            tile.textContent = letter;
            currentCol++;
        }
    }

    function deleteLetter() {
        if (currentCol > 0) {
            currentCol--;
            const tile = document.querySelector(`.tile[data-row="${currentRow}"][data-col="${currentCol}"]`);
            tile.textContent = "";
        }
    }

    function submitRow() {
        if (currentCol < maxCols) {
            alert("Mot trop court !");
            return;
        }

        let guessWord = "";
        const tiles = [];
        for (let i = 0; i < maxCols; i++) {
            const tile = document.querySelector(`.tile[data-row="${currentRow}"][data-col="${i}"]`);
            tiles.push(tile);
            guessWord += tile.textContent;
        }

        const secretArray = secretWord.split("");
        const guessArray = guessWord.split("");
        const statuses = Array(maxCols).fill("absent");

        for (let i = 0; i < maxCols; i++) {
            if (guessArray[i] === secretArray[i]) {
                statuses[i] = "correct";
                secretArray[i] = null;
                guessArray[i] = null;
            }
        }

        for (let i = 0; i < maxCols; i++) {
            if (guessArray[i] !== null) {
                const indexInSecret = secretArray.indexOf(guessArray[i]);
                if (indexInSecret !== -1) {
                    statuses[i] = "present";
                    secretArray[indexInSecret] = null;
                }
            }
        }

        tiles.forEach((tile, i) => {
            const letter = tile.textContent;
            tile.classList.add(statuses[i]);
            updateKeyColor(letter, statuses[i]);
        });

        if (guessWord === secretWord) {
            setTimeout(() => alert("Bravo, tu as gagné !"), 200);
            //On calcule le temps passé et on envoie la sauvegarde (isWon = true)
            const timeSeconds = Math.floor(Date.now() / 1000) - startTime;
            saveGameResult(wordId, currentRow + 1, timeSeconds, true);
            return;
        }

        currentRow++;
        currentCol = 0;

        if (currentRow === maxRows) {
            setTimeout(() => alert(`Partie terminée ! Le mot était : ${secretWord}`), 200);
            // On calcule le temps passé et on envoie la sauvegarde (isWon = false)
            const timeSeconds = Math.floor(Date.now() / 1000) - startTime;
            saveGameResult(wordId, maxRows, timeSeconds, false);
        }
    }

    function updateKeyColor(letter, status) {
        const key = document.querySelector(`.key[data-key="${letter}"]`);
        if (!key) return;

        if (key.classList.contains("correct")) return;
        if (status === "correct") {
            key.classList.remove("present", "absent");
            key.classList.add("correct");
        } else if (status === "present" && !key.classList.contains("present")) {
            key.classList.add("present");
        } else if (status === "absent" && !key.classList.contains("present")) {
            key.classList.add("absent");
        }
    }
    function saveGameResult(wordId, attempts, timeSeconds, isWon) {
        const resultData = {
            word_id: wordId,
            attempts: attempts,
            time_seconds: timeSeconds,
            is_won: isWon
        };

        fetch('index.php?action=saveGame', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(resultData)
        })
            .then(response => response.json())
            .then(data => console.log("Partie enregistrée :", data))
            .catch(error => console.error("Erreur lors de la sauvegarde :", error));
    }
});