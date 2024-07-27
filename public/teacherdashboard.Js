const carousel = document.querySelector('.carousel');
const carouselSlides = document.querySelectorAll('.carousel-slide');
const prev = document.getElementById('prev');
const next = document.getElementById('next');

let slideIndex = 0;

function showSlides() {
  carouselSlides.forEach((slide, index) => {
    if (index === slideIndex) {
      slide.style.display = 'block';
    } else {
      slide.style.display = 'none';
    }
  });
}

function nextSlide() {
  slideIndex++;
  if (slideIndex >= carouselSlides.length) {
    slideIndex = 0;
  }
  showSlides();
}

function prevSlide() {
  slideIndex--;
  if (slideIndex < 0) {
    slideIndex = carouselSlides.length - 1;
  }
  showSlides();
}

next.addEventListener('click', nextSlide);
prev.addEventListener('click', prevSlide);

showSlides();
setInterval(nextSlide, 5000); // auto slide every 5 seconds
