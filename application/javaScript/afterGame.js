const popup = document.getElementById('maPopup');
const ouvrirBtn = document.getElementById('ouvrirBtn');
const fermerBtn = document.getElementById('fermerBtn');

// Ouvrir la popup en mode "modal" (bloque l'arrière-plan)
ouvrirBtn.addEventListener('click', () => {
  popup.showModal();
});

// Fermer la popup
fermerBtn.addEventListener('click', () => {
  popup.close();
});

// Fermer si on clique en dehors de la popup (sur le fond grisé)
popup.addEventListener('click', (event) => {
  const rect = popup.getBoundingClientRect();
  const isInDialog = (
    rect.top <= event.clientY &&
    event.clientY <= rect.bottom &&
    rect.left <= event.clientX &&
    event.clientX <= rect.right
  );
  if (!isInDialog) {
    popup.close();
  }
});