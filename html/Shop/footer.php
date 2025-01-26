<footer class="footer">
    <div class="social-icons">
        <a href="https://facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="https://x.com/" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="https://instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="https://linkedin.com/" target="_blank"><i class="fab fa-linkedin-in"></i></a>
    </div>
    © 2024 Visit Syria. جميع الحقوق محفوظة.
</footer>
<script>
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");

        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }

        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}    

        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" actٍive", "");
        }

        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";

        setTimeout(showSlides, 4000);
    }

    function toggleMenu() { 
        var headerButtons = document.querySelector('.header-buttons');
        headerButtons.classList.toggle('active'); 
    }

    $(document).ready(function() {
        $('.add-to-cart-button').click(function() {
            var form = $(this).closest('.add-to-cart-form');
            var productId = form.find('input[name="product_id"]').val();
            var quantity = form.find('input[name="quantity"]').val();

            $.ajax({
                type: "POST",
                url: "add_to_cart.php",
                data: { product_id: productId, quantity: quantity },
                dataType: "json",
                success: function(response) {
                    if (response && response.cartCount !== undefined) {
                        $('.cart-count').text(response.cartCount);
                        $('#message').text('تمت إضافة المنتج إلى السلة بنجاح!').fadeIn().delay(3000).fadeOut();
                    } else {
                        $('#message').text('لم يتم تحديث العدد في السلة.').fadeIn().delay(3000).fadeOut();
                    }
                },
                error: function() {
                    $('#message').text('حدث خطأ أثناء إضافة المنتج إلى السلة.').fadeIn().delay(3000).fadeOut();
                }
            });
        });
    });
</script>
</body>
</html>