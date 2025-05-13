// JavaScript para hacer el acordeón funcional
const faqs = document.querySelectorAll('.faq-question');
faqs.forEach(faq => {
    faq.addEventListener('click', () => {
        faq.classList.toggle('active');
        const answer = faq.nextElementSibling;
        answer.style.maxHeight = answer.style.maxHeight ? null : answer.scrollHeight + "px";
    });
});