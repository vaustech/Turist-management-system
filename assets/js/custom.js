$(document).ready(function(){

    // --- Sticky Footer Function START ---
    function stickyFooter() {
        var windowHeight = $(window).height();
        var contentHeight = $('body').outerHeight();
        var footer = $('.site-footer');
        var footerHeight = footer.outerHeight();

        if (contentHeight + footerHeight < windowHeight) {
            // কন্টেন্ট ছোট হলে footer সবসময় নিচে যাবে
            footer.css({
                'position': 'absolute',
                'bottom': '0',
                'width': '100%'
            });

            // যাতে overlap না হয়
            $('body').css('margin-bottom', footerHeight + 'px');
        } else {
            // কন্টেন্ট বড় হলে footer স্বাভাবিক থাকবে
            footer.css({
                'position': 'static',
                'width': '100%'
            });
            $('body').css('margin-bottom', '0');
        }
    }

    // পেজ লোড হওয়ার সময় ফাংশন চালানো
    stickyFooter();

    // স্ক্রিন resize হলে ফাংশন আবার চালানো
    $(window).resize(function() {
        stickyFooter();
    });
    // --- Sticky Footer Function END ---


    // "Our Popular Packages" ক্যারোসেল
    $('.packages-carousel').owlCarousel({
        loop: true,
        margin: 30,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive:{
            0:{ items: 1 },
            768:{ items: 2 },
            992:{ items: 3 }
        }
    });

    // "Testimonials" ক্যারোসেল
    $('.testimonial-carousel').owlCarousel({
        loop: true,
        margin: 30,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsive:{
            0:{ items: 1 },
            768:{ items: 2 },
            992:{ items: 3 }
        }
    });

    // Animated Counter
    var counterAnimated = false; 

    $(window).on('scroll', function() {
        if (!counterAnimated) {
            var statsSection = $('.stats-section');
            if (statsSection.length > 0) { 
                var top_of_element = statsSection.offset().top;
                var bottom_of_window = $(window).scrollTop() + $(window).height();

                if (bottom_of_window > top_of_element) {
                    $('.stat-number').each(function() {
                        var $this = $(this),
                            countTo = $this.attr('data-target');
                        
                        $({ countNum: 0 }).animate({
                            countNum: countTo
                        },
                        {
                            duration: 2000, 
                            easing: 'swing',
                            step: function() {
                                $this.text(Math.floor(this.countNum) + '+');
                            },
                            complete: function() {
                                $this.text(this.countNum + '+');
                            }
                        });
                    });
                    counterAnimated = true; 
                }
            }
        }
    });

});
