AOS.init();

// SLIDER PORTADA
var swPortada = new Swiper('.swPortada',{
	loop: true,
	effect: "fade",
	autoplay: {
		delay: 4000,
		disableOnInteraction: true,
	},
	pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

// DAR CLASE CUANDO MENÚ ESTÁ ACTIVADO
const burger = document.getElementById("burger");
const navegacion = document.getElementById("navegacion");
burger.addEventListener("change", () => {
	if (burger.checked) {
		navegacion.classList.add("active");
	} else {
		navegacion.classList.remove("active");
	}
});

// SLIDER TENIS
var swTenis = new Swiper('.swTenis', {
	slidesPerView: 1,
	spaceBetween: 15,
	pagination: {
		el: ".swiper-pagination",
		clickable: true,
	},
	autoplay: {
		delay: 2500,
		disableOnInteraction: false,
	},
	navigation: {
		prevEl: ".swTenis .swiper-button-prev",
		nextEl: ".swTenis .swiper-button-next",
	},
	breakpoints: {
		320: {
			slidesPerView: 1,
			slidesPerGroup: 1,
		},
		992: {
			slidesPerView: 2,
			slidesPerGroup: 2,
		},
		1200: {
			slidesPerView: 3,
			slidesPerGroup: 3,
		},
	},
});

// SLIDER ACTIVIDADES
var swActividades = new Swiper('.swActividades', {
	slidesPerView: 1,
	spaceBetween: 15,
	pagination: {
		el: ".swiper-pagination",
		clickable: true,
	},
	autoplay: {
		delay: 2500,
		disableOnInteraction: false,
	},
	navigation: {
		prevEl: ".swActividades .swiper-button-prev",
		nextEl: ".swActividades .swiper-button-next",
	},
	breakpoints: {
		320: {
			slidesPerView: 1,
			slidesPerGroup: 1,
		},
		992: {
			slidesPerView: 3,
			slidesPerGroup: 3,
		},
		1200: {
			slidesPerView: 4,
			slidesPerGroup: 4,
		},
	},
});

// SLIDER ENTRENADORES
var swEntrenadores = new Swiper('.swEntrenadores', {
	slidesPerView: 1,
	spaceBetween: 15,
	pagination: {
		el: ".swiper-pagination",
		clickable: true,
	},
	autoplay: {
		delay: 2500,
		disableOnInteraction: false,
	},
	navigation: {
		prevEl: ".swEntrenadores .swiper-button-prev",
		nextEl: ".swEntrenadores .swiper-button-next",
	},
	breakpoints: {
		320: {
			slidesPerView: 1,
			slidesPerGroup: 1,
		},
		992: {
			slidesPerView: 3,
			slidesPerGroup: 3,
		},
		1200: {
			slidesPerView: 4,
			slidesPerGroup: 4,
		},
	},
});

// SLIDER NOTICIAS
var swTenis = new Swiper('.swNoticias', {
	slidesPerView: 1,
	spaceBetween: 15,
	pagination: {
		el: ".swiper-pagination",
		clickable: true,
	},
	autoplay: {
		delay: 2500,
		disableOnInteraction: false,
	},
	navigation: {
		prevEl: ".swNoticias .swiper-button-prev",
		nextEl: ".swNoticias .swiper-button-next",
	},
	breakpoints: {
		320: {
			slidesPerView: 1,
			slidesPerGroup: 1,
		},
		992: {
			slidesPerView: 2,
			slidesPerGroup: 2,
		},
		1200: {
			slidesPerView: 3,
			slidesPerGroup: 3,
		},
	},
});