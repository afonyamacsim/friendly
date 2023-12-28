jQuery(document).ready(function () {
    if (jQuery('.header-logo-menu').length) {
        jQuery('.header-logo-menu').click(function () {
            jQuery(this).toggleClass('active');
            jQuery('.header-top').toggleClass('fix');
            jQuery('body').toggleClass('fix');
            jQuery('html').toggleClass('fix');

            jQuery('.hidden-menu').toggleClass('open');
            return false;
        });
    }
    if (jQuery('.accordion').length) {
        const items = document.querySelectorAll(".accordion button");

        function toggleAccordion() {
            const itemToggle = this.getAttribute('aria-expanded');

            for (i = 0; i < items.length; i++) {
                items[i].setAttribute('aria-expanded', 'false');
            }

            if (itemToggle == 'false') {
                this.setAttribute('aria-expanded', 'true');
            }
        }

        items.forEach(item => item.addEventListener('click', toggleAccordion));
    }
    if (jQuery('.sliders').length > 0) {
        var swiper_list = jQuery("[data-slider-id]");
        jQuery(swiper_list).each(function () {
            let swiper_slider_id = jQuery(this).attr('data-slider-id');
            var slider = new Swiper(".sliders", {
                slidesPerView: 4,
                spaceBetween: 40,
                loop: true,
                speed: 2000,
                autoplay: {
                    enabled: true,
                    delay: 1,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    1170: {
                        slidesPerView: 2,
                        spaceBetween: 40,
                    },
                    769: {
                        slidesPerView: 1.15,
                        spaceBetween: 20,
                    },
                },
                on: {
                    init() {
                        this.el.addEventListener('mouseenter', () => {
                            this.autoplay.stop();
                        });

                        this.el.addEventListener('mouseleave', () => {
                            this.autoplay.start();
                        });
                    }
                },
            });
        });

    }
    if (jQuery('input[type="tel"]').length) {
        jQuery('input[type="tel"]').mask('+7 (999) 999-99-99');
    }
    if (jQuery('.start-numb').length) {
        let $element = jQuery('.start-numb');
        let counter = 0;
        jQuery(window).on('scroll', function () {
            let scroll = jQuery(window).scrollTop() + jQuery(window).height();
            //Если скролл до конца елемента
            let offset = $element.offset().top + $element.height();
            //Если скролл до начала елемента
            // var offset = $element.offset().top
            if (scroll > offset && counter == 0) {

                jQuery(function () {
                    var fx = function fx() {
                        jQuery(".stat-number").each(function (i, el) {
                            var data = parseInt(this.dataset.n, 10);
                            var props = {
                                "from": {
                                    "count": 0
                                },
                                "to": {
                                    "count": data
                                }
                            };
                            jQuery(props.from).animate(props.to, {
                                duration: 1000 * 1,
                                step: function (now, fx) {
                                    jQuery(el).text(Math.ceil(now));
                                },
                                complete: function () {
                                    if (el.dataset.sym !== undefined) {
                                        el.textContent = el.textContent.concat(el.dataset.sym)
                                    }
                                }
                            });
                        });
                    };
                    var reset = function reset() {
                        if (jQuery(this).scrollTop() > 90) {
                            jQuery(this).off("scroll");
                            fx()
                        }
                    };

                    jQuery(window).on("scroll", reset);
                });
            }
        });
    }
})