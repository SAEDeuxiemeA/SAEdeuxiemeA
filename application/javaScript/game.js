document.addEventListener("DOMContentLoaded", () => {
    let currentRow = 0;
    let currentCol = 0;
    const maxRows = 6;
    const maxCols = 5;
    let gameOver = false;
    const startTime = Date.now();
    
    const keys = document.querySelectorAll(".key");
    keys.forEach(key => {
        key.addEventListener("click", () => {
            const keyValue = key.getAttribute("data-key");
            handleKeyPress(keyValue);
        });
    });

    document.addEventListener("keydown", (e) => {
        if (gameOver) return;

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

    function clearMessage() {
        const messageElement = document.getElementById("game-message");
        if (messageElement) {
            messageElement.textContent = "";
        }
    }

    function handleKeyPress(key) {
        if (gameOver) return;

        clearMessage();

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

    function showMessage(text) {
        const messageElement = document.getElementById("game-message");
        if (!messageElement) return;
        messageElement.textContent = text;
    }

    function submitRow() {
        if (currentCol < maxCols) {
            showMessage("Mot trop court !")
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

        const isWon = (guessWord === secretWord);
        currentRow++;
        currentCol = 0;

        if (isWon || currentRow === maxRows) {
            gameOver = true;
            const timeSeconds = Math.round((Date.now() - startTime) / 1000);
            
            saveGameResults(wordId, currentRow, timeSeconds, isWon);

            setTimeout(() => {
                if (isWon) {
                    showModal("Victoire !", "Bravo, tu as gagné !");
                } else {
                    showModal("Défaite", `Partie terminée ! Le mot était : ${secretWord}`);
                }
            }, 250);
        }
    }

    function showModal(title, message) {
        const modal = document.getElementById("game-over-modal");
        const titleEl = document.getElementById("modal-title");
        const messageEl = document.getElementById("modal-message");

        if (!modal) return;

        titleEl.textContent = title;
        messageEl.textContent = message;

        modal.showModal();
    }

    const closeBtn = document.getElementById("modal-close-btn");
    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            const modal = document.getElementById("game-over-modal");
            modal.close();
            location.reload();
        });
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

    function saveGameResults(wordId, attempts, timeSeconds, isWon) {
        fetch("index.php?action=saveGame", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                word_id: wordId,
                attempts: attempts,
                time_seconds: timeSeconds,
                is_won: isWon
            })
        }).catch(err => console.error("Erreur lors de la sauvegarde :", err));
    }
});