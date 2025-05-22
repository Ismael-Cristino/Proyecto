const elegirnos = document.querySelectorAll('.elegirnos-question');

elegirnos.forEach(elegir => {
    elegir.addEventListener('click', () => {
        elegir.classList.toggle('active');
        const answer = elegir.nextElementSibling;
        if (answer) {
            answer.style.maxHeight = answer.style.maxHeight ? null : answer.scrollHeight + "px";
        } else {
            console.warn("No se encontró el .elegirnos-answer para este botón:", elegir);
        }
    });
});