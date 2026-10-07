import 'swiper/css';

import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';

/**
 * Raises the middle one of three visible slides (styled by `.lift` in app.css).
 */
function markCenterSlide(swiper) {
  swiper.slides.forEach((slide) => slide.classList.remove('is-center'));

  if (swiper.params.slidesPerView >= 3) {
    swiper.slides[swiper.activeIndex + 1]?.classList.add('is-center');
  }
}

function cardCarousel(name) {
  return new Swiper(`.${name}.swiper`, {
    modules: [Navigation, Autoplay],
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    navigation: {
      prevEl: `.${name}-prev`,
      nextEl: `.${name}-next`,
    },
    loop: true,
    slidesPerView: 1,
    spaceBetween: 8,
    breakpoints: {
      768: {
        slidesPerView: 2,
        spaceBetween: 12,
      },
      1280: {
        slidesPerView: 3.04,
        spaceBetween: 16,
      },
    },
    on: {
      init: markCenterSlide,
      slideChange: markCenterSlide,
      breakpoint: markCenterSlide,
    },
  });
}

if (document.querySelector('.main-page')) {
  cardCarousel('invest');
  cardCarousel('news');
  cardCarousel('reviews');

  new Swiper('.partners.swiper', {
    modules: [Navigation, Autoplay],
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    loop: true,
    slidesPerView: 'auto',
    spaceBetween: 16,
  });
}
