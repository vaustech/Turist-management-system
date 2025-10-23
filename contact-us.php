<?php include 'includes/header.php'; ?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h2>Contact Us</h2>
        <p class="lead">We'd love to hear from you. Please drop us a line if you have any query.</p>
    </div>
    
    <?php
    if (isset($_GET['success'])) {
        echo '<div class="alert alert-success text-center">Your message has been sent successfully. We will get back to you shortly.</div>';
    }
    ?>

    <div class="card contact-wrapper">
        <div class="row no-gutters">
            <div class="col-lg-7">
                <div class="contact-form-section">
                    <h4 class="mb-4">Send us a Message</h4>
                    <form action="handle_contact.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="contact-info">
                    <h3>Contact Information</h3>
                    <p>Our team is available to answer your questions from Sunday to Thursday, 9am to 6pm.</p>
                    <div class="d-flex mt-4">
                        <i class="fas fa-map-marker-alt icon"></i>
                        <p>Nurjahan Sharif Plaza,Purana Palton,Dhaka-1200, Bangladesh</p>
                    </div>
                    <div class="d-flex mt-3">
                        <i class="fas fa-phone icon"></i>
                        <p>+880 1234 567890</p>
                    </div>
                    <div class="d-flex mt-3">
                        <i class="fas fa-envelope icon"></i>
                        <p>contact@porjotok.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>