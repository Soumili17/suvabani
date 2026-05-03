<footer class="footer">
    <div class="footer-container">

        <div class="footer-box">
            <h2>SUVABANI FOUNDATION</h2>
            <p>Dedicated to social welfare and sustainable community development.</p>

            <div class="social-icons" style="margin-top: 15px;">
                <a href="https://www.facebook.com/SUVABANIFOUNDATION" style="margin-right:15px; color:white; font-size: 20px;"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/suvabanifoundation_?igsh=dW05dzc5NDFiczJo" style="margin-right:15px; color:white; font-size: 20px;"><i class="fab fa-instagram"></i></a>
                <a href="https://youtube.com/@suvabanifoundation?si=vvx08zGmsC5jKG9l" style="margin-right:15px; color:white; font-size: 20px;"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <div class="footer-box">
            <h3>Contact Information</h3>
            <p style="margin-top: 10px;">
                Rania Pravat Pally,<br>
                P.O. Boral, P.S. Narendrapur,<br>
                Kolkata – 700154
            </p>
        </div>

        <div class="footer-box">
            <h3>Reach Us</h3>
            <p style="margin-top: 10px;">Phone: 7059590022</p>
            <p>Email:
                <a style="color:white; text-decoration:none;" href="mailto:suvabanifoundation@gmail.com">
                    suvabanifoundation@gmail.com
                </a>
            </p>
        </div>

    </div>

    <div class="footer-bottom">
        © 2026 SUVABANI FOUNDATION |
        <a href="{{ route('terms') }}" style="color: white; text-decoration: underline;">Terms & Conditions</a>
    </div>
</footer>

<!-- Back To Top -->
<button id="backTop" style="display:none; position:fixed; bottom:20px; right:20px; z-index:99; background:#003f88; color:white; border:none; padding:10px 15px; border-radius:50%; cursor:pointer;">↑</button>

<script>
    window.onscroll = function() {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            document.getElementById("backTop").style.display = "block";
        } else {
            document.getElementById("backTop").style.display = "none";
        }
    };
    document.getElementById("backTop").addEventListener("click", function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
