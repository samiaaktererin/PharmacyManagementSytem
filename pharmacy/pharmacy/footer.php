</div> <!-- container-fluid -->

<!-- FOOTER -->
<footer class="footer mt-5">
  <div class="container py-3">
    <div class="row align-items-center">
      <!-- About -->
      <div class="col-md-8 mb-2">
        <h6 class="text-uppercase fw-bold"><i class="fa-solid fa-capsules"></i> Pharmacy</h6>
        <p class="small text-muted">
          “Your health, our priority. Trusted medicines and compassionate care, ensuring a healthier tomorrow for you and your loved ones.”
        </p>
      </div>
      <!-- Social Links -->
      <div class="col-md-4 mb-2 text-md-end">
        <h6 class="text-uppercase fw-bold">Follow Us</h6>
        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
    <hr class="footer-divider">
    <div class="text-center small text-muted">
      &copy; <?php echo date("Y"); ?> Pharmacy Admin. All rights reserved.
    </div>
  </div>
</footer>

<style>
  /* Footer Styling */
  .footer {
    background: linear-gradient(90deg, #041424, #04192e); /* dark gradient */
    color: #f8f9fa; /* light text for readability */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    border-radius: 12px 12px 0 0;
    box-shadow: 0 -1px 4px rgba(0,0,0,0.05);
    padding: 12px 20px; /* compact padding */
    font-size: 14px;
  }

  .footer a {
    color: #f8f9fa;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 14px;
  }

  .footer a:hover {
    color: #1cc88a;
  }

  .footer h6 {
    font-weight: 700;
    margin-bottom: 8px;
    font-size: 15px;
    color: #f8f9fa;
  }

  .footer .social-link {
    display: inline-block;
    margin-right: 8px;
    font-size: 16px;
    color: #f8f9fa;
    transition: color 0.3s ease, transform 0.2s ease;
  }

  .footer .social-link:hover {
    color: #1cc88a;
    transform: scale(1.1);
  }

  .footer-divider {
    border-color: rgba(255,255,255,0.2);
    margin-top: 10px;
    margin-bottom: 10px;
  }

  .footer .text-muted {
    color: #d1d1d1 !important; /* consistent muted text */
    font-size: 13px;
  }

  .footer .small {
    font-size: 13px;
  }
</style>
