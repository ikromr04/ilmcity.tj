import 'swiper/css';

import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';

if (document.querySelector('.main-page')) {
  new Swiper('.invest.swiper', {
    modules: [Navigation, Autoplay],
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
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
        slidesPerView: 3,
        spaceBetween: 16,
      },
    }
  });

  new Swiper('.news.swiper', {
    modules: [Navigation, Autoplay],
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
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
        slidesPerView: 3,
        spaceBetween: 16,
      },
    }
  });

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

  new Swiper('.reviews.swiper', {
    modules: [Navigation, Autoplay],
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
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
        slidesPerView: 3,
        spaceBetween: 16,
      },
    }
  });
}
