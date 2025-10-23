<?php
// হেডার এবং ডাটাবেস কানেকশন ফাইল যুক্ত করা হচ্ছে
require_once('includes/_dbconnect.php');
include('includes/header.php');
?>

<section class="hero-section">
    <video playsinline autoplay muted loop class="hero-video">
        <source src="assets/videos/hero-video.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="hero-content">
        <h1>Find Your Next Adventure</h1>
        <p>Unforgettable Journeys, Unbeatable Prices</p>
        <a href="popular-package.php" class="btn btn-primary btn-lg">Explore Packages</a>
    </div>
</section>


<section class="popular-packages py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Our Popular Packages</h2>
        <div class="packages-carousel owl-carousel owl-theme">
            <?php
            $sql_packages = "SELECT * FROM tbl_tourpackage ORDER BY id DESC LIMIT 6";
            $result_packages = mysqli_query($conn, $sql_packages);
            if (mysqli_num_rows($result_packages) > 0) {
                while ($row = mysqli_fetch_assoc($result_packages)) {
            ?>
                    <div class="item">
                        <div class="card package-card h-100"><img src="uploads/<?php echo htmlspecialchars($row['package_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['package_name']); ?>"><div class="card-body d-flex flex-column"><h5 class="card-title"><?php echo htmlspecialchars($row['package_name']); ?></h5><p class="card-text"><b>Location:</b> <?php echo htmlspecialchars($row['package_location']); ?></p><h6 class="price mt-auto">Price: BDT <?php echo number_format($row['package_price']); ?>/-</h6><a href="package-details.php?pkgid=<?php echo $row['id']; ?>" class="btn btn-success mt-2">View Details</a></div></div>
                    </div>
            <?php } } ?>
        </div>
    </div>
</section>

<section class="testimonials-section py-5">
    <div class="container">
        <h2 class="text-center mb-5">What Our Customers Say</h2>
        <div class="testimonial-carousel owl-carousel owl-theme">
           <?php
            $sql_testimonials = "SELECT * FROM tbl_testimonials WHERE status = 1 ORDER BY id DESC LIMIT 5";
            $result_testimonials = mysqli_query($conn, $sql_testimonials);
            if (mysqli_num_rows($result_testimonials) > 0) {
                while ($row = mysqli_fetch_assoc($result_testimonials)) {
            ?>
                   



<div class="testimonial-card">
    <img src="uploads/testimonials/<?php echo htmlspecialchars($row['user_image']); ?>" alt="<?php echo htmlspecialchars($row['user_name']); ?>">
    
    <div class="display-stars my-3">
        <?php 
        // ডাটাবেস থেকে আসা রেটিং সংখ্যা (ধরা যাক, $row['rating'])
        $rating = isset($row['rating']) ? intval($row['rating']) : 0;
        
        // ৫টি স্টারের জন্য লুপ চালানো হচ্ছে
        for($i = 1; $i <= 5; $i++): 
        ?>
            <?php if($i <= $rating): ?>
                <i class="fas fa-star"></i> <?php else: ?>
                <i class="far fa-star"></i> <?php endif; ?>
        <?php endfor; ?>
    </div>

    <p class="testimonial-text">"<?php echo htmlspecialchars($row['message']); ?>"</p>
    <h5 class="customer-name"><?php echo htmlspecialchars($row['user_name']); ?></h5>
</div>

            <?php } } ?>
        </div>
    </div>
</section>

<section class="meet-guide-section py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Meet Our Expert Guides</h2>
        <div class="row justify-content-center">
            <?php
            // tbl_guides টেবিল থেকে তথ্য আনা হচ্ছে
            $sql_guides = "SELECT * FROM tbl_guides ORDER BY display_order ASC, id ASC LIMIT 3";
            $result_guides = mysqli_query($conn, $sql_guides);
            if (mysqli_num_rows($result_guides) > 0) {
                while ($row_guide = mysqli_fetch_assoc($result_guides)) {
            ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="guide-card">
                            <img src="uploads/guides/<?php echo htmlspecialchars($row_guide['guide_image']); ?>" alt="<?php echo htmlspecialchars($row_guide['guide_name']); ?>">
                            <h5 class="guide-name"><?php echo htmlspecialchars($row_guide['guide_name']); ?></h5>
                            <p class="guide-specialty"><i class="fas fa-award"></i> <?php echo htmlspecialchars($row_guide['guide_specialty']); ?></p>
                        </div>
                    </div>
            <?php
                } // while লুপের শেষ
            } else {
                echo "<p class='text-center col-12'>Guide information will be updated soon.</p>";
            }
            ?>
        </div> </div> </section>

<section class="stats-section">
    <div class="container">
         <h2 class="text-center mb-5">Our Delivary </h2>
        <h2 class="text-center mb-5" style="color: #495057;"></h2>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="stat-card">
                    <i class="fas fa-users stat-icon"></i>
                    <h2 class="stat-number" data-target="500">0+</h2>
                    <p>Happy Customers</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card">
                    <i class="fas fa-route stat-icon"></i>
                    <h2 class="stat-number" data-target="150">0+</h2>
                    <p>Tours Completed</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card">
                    <i class="fas fa-map-marked-alt stat-icon"></i>
                    <h2 class="stat-number" data-target="50">0+</h2>
                    <p>Destinations</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- //Why Choose Us section -->


<section class="why-choose-us-section py-5">
    <div class="container">
        <h2 class="text-center mb-5">Why Choose Us?</h2>
        <div class="row">
            <div class="col-md-4 mb-4"><div class="feature-box"><i class="fas fa-wallet icon"></i><h3>Best Price Guarantee</h3><p>We provide the best travel experiences at the most competitive prices.</p></div></div>
            <div class="col-md-4 mb-4"><div class="feature-box"><i class="fas fa-headset icon"></i><h3>24/7 Customer Support</h3><p>Our dedicated support team is always available to assist you with any queries.</p></div></div>
            <div class="col-md-4 mb-4"><div class="feature-box"><i class="fas fa-user-shield icon"></i><h3>Safe & Secure Tours</h3><p>Your safety is our top priority. We ensure all our tours are safe and well-managed.</p></div></div>
        </div>
    </div>







<section class="newsletter-section py-5">
    <div class="container text-center">
        <h2>Subscribe to Our Newsletter</h2>
        <p class="lead">Get the latest updates on new packages and special offers!</p>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <form action="handle_newsletter.php" method="POST">
                    <div class="input-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
                        <div class="input-group-append"><button class="btn btn-primary" type="submit">Subscribe</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
$(document).ready(function(){
    // প্যাকেজ ক্যারোসেল চালু করা
$('.packages-carousel').owlCarousel({
    loop: true,
    margin: 30,
    nav: false,                 // <- পরিবর্তন: false করা হয়েছে ('>' '<' চিহ্ন চলে যাবে)
    dots: true,                 // <- পরিবর্তন: true করা হয়েছে (ডট চিহ্ন আসবে)
    autoplay: true,             // <- নতুন: autoplay চালু করা হয়েছে
    autoplayTimeout: 3000,      // <- নতুন: ৩ সেকেন্ড পর পর স্লাইড হবে
    autoplayHoverPause: true,   // <- নতুন: মাউস রাখলে স্লাইড থেমে যাবে
    responsive:{
        0:{ items: 1 },
        768:{ items: 2 },
        992:{ items: 3 }
    }
});

    $('.testimonial-carousel').owlCarousel({
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
});

  //animation code
  const statsSection = document.querySelector('.stats-section');

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counters = document.querySelectorAll('.stat-number');
                counters.forEach(counter => {
                    counter.innerText = '0+'; // প্রথমে ০ সেট করা
                    const target = +counter.getAttribute('data-target');
                    const speed = 200; // অ্যানিমেশনের গতি

                    const updateCount = () => {
                        const count = +counter.innerText.replace('+', '');
                        const increment = target / speed;

                        if (count < target) {
                            counter.innerText = Math.ceil(count + increment) + '+';
                            setTimeout(updateCount, 10);
                        } else {
                            counter.innerText = target + '+';
                        }
                    };
                    updateCount();
                });
                observer.unobserve(statsSection); // অ্যানিমেশন একবার চলার পর বন্ধ হয়ে যাবে
            }
        });
    }, {
        threshold: 0.5 // সেকশনের ৫০% দেখা গেলে অ্যানিমেশন শুরু হবে
    });

    if (statsSection) {
        observer.observe(statsSection);
    }

});
</script>

<?php 
include 'includes/footer.php'; 
?>