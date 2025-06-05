let slideIndex = 0;
let slides, dots, autoSlideInterval;

function showSlide(index) {
  slides.forEach((slide, i) => {
    slide.classList.remove("active");
    dots[i].classList.remove("active");
  });

  slides[index].classList.add("active");
  dots[index].classList.add("active");
}

function plusSlides(n) {
  stopAutoSlide();
  slideIndex = (slideIndex + n + slides.length) % slides.length;
  showSlide(slideIndex);
  startAutoSlide();
}

function currentSlide(n) {
  stopAutoSlide();
  slideIndex = n - 1;
  showSlide(slideIndex);
  startAutoSlide();
}

function startAutoSlide() {
  autoSlideInterval = setInterval(() => {
    slideIndex = (slideIndex + 1) % slides.length;
    showSlide(slideIndex);
  }, 5000);
}

function stopAutoSlide() {
  clearInterval(autoSlideInterval);
}

document.addEventListener("DOMContentLoaded", () => {
  slides = Array.from(document.querySelectorAll(".mySlide"));
  dots = Array.from(document.querySelectorAll(".dot"));

  showSlide(slideIndex);
  startAutoSlide();
});
