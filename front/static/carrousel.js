const container = document.getElementById('carrousel-container');
const prevBtn = document.querySelector('.bouton.prev');
const nextBtn = document.querySelector('.bouton.next');

const slides = container.querySelectorAll('img');
const totalSlides = slides.length;

let currentIndex = 0;

function updateCarousel() {
  const translateX = -currentIndex * 100;
  container.style.transform = `translateX(${translateX}%)`;
}

nextBtn.addEventListener('click', () => {
  currentIndex++;
  if (currentIndex >= totalSlides) {
    currentIndex = 0;
  }
  updateCarousel();
});

prevBtn.addEventListener('click', () => {
  currentIndex--;
  if (currentIndex < 0) {
    currentIndex = totalSlides - 1;
  }
  updateCarousel();
});