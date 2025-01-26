<?php
require_once "header.php";
?>

<section class="hero">
    <div class="text-center">
        <h2>مرحبا بكم في متجر Visit Syria</h2>
        <br><p>استكشف المنتجات المميزة التي تعكس جمال التراث السوري</p>
    </div>
</section>

<div class="slideshow-container">
    <div class="mySlides fade"><img src="images/slides/1.png" alt="Slide 1"></div>
    <div class="mySlides fade"><img src="images/slides/2.png" alt="Slide 2"></div>
    <div class="mySlides fade"><img src="images/slides/3.png" alt="Slide 3"></div>
    <div class="mySlides fade"><img src="images/slides/4.png" alt="Slide 4"></div>
</div>
<div style="text-align:center">
    <span class="dot"></span> 
    <span class="dot"></span> 
    <span class="dot"></span> 
    <span class="dot"></span> 
</div>


<div class="container mt-4">
    <h2 class="section-title">منتجاتنا</h2>
    <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $category => $productsInCategory): ?>
            <h3 class="subsection-title"><?= htmlspecialchars($category); ?></h3>
            <div class="product-container">
                <?php foreach ($productsInCategory as $product): ?>
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($product['image']); ?>" class="product-image" alt="<?= htmlspecialchars($product['name']); ?>">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
                        <p class="card-text">السعر: <?= htmlspecialchars($product['price']); ?> ل.س</p>
                        <form class="add-to-cart-form" method="POST">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="button" class="btn btn-primary add-to-cart-button">إضافة إلى السلة</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>لا توجد منتجات متاحة حاليًا.</p>
    <?php endif; ?>
</div>
<section id="social-media-cards" class="social-media-section">
    <div class="container">
        <div class="section-header">
            <h2>تابعونا</h2>
        </div>
        <div class="cards-container">
            <!-- بطاقة تويتر -->
            <div class="social-card">
                <div class="card-content">
                    <div class="card-header">
                        <p class="card-text">تابعونا على اكس ليصلكم كل جديد!</p>
                        <img src="https://images.ctfassets.net/vy53kjqs34an/5GjLZ1LXDtYN0f5k2AR3Lv/d166c03a1bf9bb816dd1fb240a8c6b7a/twitter.png?w=40&h=40" alt="Twitter" class="social-icon">
                    </div>
                    <a href="https://x.com/" target="_blank" class="follow-button">تابعنا الآن!</a>
                </div>
                <img src="https://images.ctfassets.net/vy53kjqs34an/7Ev2MaKdm1FhgZr2MWDjpB/971d8eefd96833e12a15e7e751d2a020/Follow_on_X.png?fm=webp&w=358&h=239" alt="Twitter Background" class="card-background">
            </div>

            <!-- بطاقة إنستغرام -->
            <div class="social-card">
                <div class="card-content">
                    <div class="card-header">
                        <p class="card-text">تابعونا على انستقرام ليصلكم كل جديد!</p>
                        <img src="https://images.ctfassets.net/vy53kjqs34an/1n0pNUr3EtLOiYPwnVoxPf/34c27b57e3f2063ef6aafdcfab1e25ed/Instagram_icon.png?w=40&h=40" alt="Instagram" class="social-icon">
                    </div>
                    <a href="https://instagram.com/" target="_blank" class="follow-button">تابعنا الآن!</a>
                </div>
                <img src="https://images.ctfassets.net/vy53kjqs34an/7Ev2MaKdm1FhgZr2MWDjpB/971d8eefd96833e12a15e7e751d2a020/Follow_on_X.png?fm=webp&w=358&h=239" alt="Instagram Background" class="card-background">
            </div>

            <!-- بطاقة تيك توك -->
            <div class="social-card">
                <div class="card-content">
                    <div class="card-header">
                        <p class="card-text">تابعونا على تيك توك ليصلكم كل جديد!</p>
                        <img src="https://images.ctfassets.net/vy53kjqs34an/24Hzd8rJ0gUazDFSIfa9n0/64a5a68a2c2b12570cdcb3b6d6cfa269/tiktok-icon.png?w=40&h=40" alt="TikTok" class="social-icon">
                    </div>
                    <a href="https://www.tiktok.com/" target="_blank" class="follow-button">تابعنا الآن!</a>
                </div>
                <img src="https://images.ctfassets.net/vy53kjqs34an/7Ev2MaKdm1FhgZr2MWDjpB/971d8eefd96833e12a15e7e751d2a020/Follow_on_X.png?fm=webp&w=358&h=239" alt="TikTok Background" class="card-background">
            </div>

            <!-- بطاقة يوتيوب -->
            <div class="social-card">
                <div class="card-content">
                    <div class="card-header">
                        <p class="card-text">تابعونا على يوتيوب ليصلكم كل جديد!</p>
                        <img src="https://images.ctfassets.net/vy53kjqs34an/5J2bFef3dZmvMVQECq4n24/71136a8cfadfb0320b5ff0f28a9eb841/youtube.png?w=40&h=40" alt="YouTube" class="social-icon">
                    </div>
                    <a href="https://www.youtube.com/" target="_blank" class="follow-button">تابعنا الآن!</a>
                </div>
                <img src="https://images.ctfassets.net/vy53kjqs34an/7Ev2MaKdm1FhgZr2MWDjpB/971d8eefd96833e12a15e7e751d2a020/Follow_on_X.png?fm=webp&w=358&h=239" alt="YouTube Background" class="card-background">
            </div>
        </div>
    </div>
</section>

<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <div class="text-content">
                <h2>ابق على اطلاع!</h2>
                <p class="description">كن أول من يحصل على عروض حصرية وابقى على اطلاع على آخر الأخبار حول منتجاتنا، كل ذلك مباشرة إلى بريدك الإلكتروني. *باشتراكك، أنت توافق على تلقي الإيميلات التسويقية</p>
                <p class="subscribe-form">
                    <fieldset>
                        <div class="input-container">
                            <input type="email" placeholder="اكتب ايميلك" name="email" class="email-input">
                        </div>
                    </fieldset>
                    <button class="subscribe-button">اشترك الأن!</button>
                </p>
            </div>
            <div class="illustration-content">
                <img src="images/writing_girl.svg" alt="Illustration" class="illustration">
                <div class="features-list">
                    <div class="feature-item">
                        <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="feature-icon">
                            <rect x="0.5" width="16" height="16" rx="8" fill="currentColor"></rect>
                            <path d="M11.8472 4.70553C12.0558 4.46006 12.424 4.43021 12.6694 4.63886C12.9149 4.84751 12.9448 5.21565 12.7361 5.46112L7.77779 11.2945C7.56586 11.5438 7.19035 11.57 6.94578 11.3526L4.32078 9.01931C4.07999 8.80528 4.0583 8.43657 4.27233 8.19578C4.48637 7.95499 4.85508 7.9333 5.09587 8.14734L7.27511 10.0844L11.8472 4.70553Z" fill="white"></path>
                        </svg>
                        <p>توصيات شخصية</p>
                    </div>
                    <div class="feature-item">
                        <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="feature-icon">
                            <rect x="0.5" width="16" height="16" rx="8" fill="currentColor"></rect>
                            <path d="M11.8472 4.70553C12.0558 4.46006 12.424 4.43021 12.6694 4.63886C12.9149 4.84751 12.9448 5.21565 12.7361 5.46112L7.77779 11.2945C7.56586 11.5438 7.19035 11.57 6.94578 11.3526L4.32078 9.01931C4.07999 8.80528 4.0583 8.43657 4.27233 8.19578C4.48637 7.95499 4.85508 7.9333 5.09587 8.14734L7.27511 10.0844L11.8472 4.70553Z" fill="white"></path>
                        </svg>
                        <p>عروض رهيبة!</p>
                    </div>
                    <div class="feature-item">
                        <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="feature-icon">
                            <rect x="0.5" width="16" height="16" rx="8" fill="currentColor"></rect>
                            <path d="M11.8472 4.70553C12.0558 4.46006 12.424 4.43021 12.6694 4.63886C12.9149 4.84751 12.9448 5.21565 12.7361 5.46112L7.77779 11.2945C7.56586 11.5438 7.19035 11.57 6.94578 11.3526L4.32078 9.01931C4.07999 8.80528 4.0583 8.43657 4.27233 8.19578C4.48637 7.95499 4.85508 7.9333 5.09587 8.14734L7.27511 10.0844L11.8472 4.70553Z" fill="white"></path>
                        </svg>
                        <p>إعلانات مسبقة</p>
                    </div>
                    <div class="feature-item">
                        <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="feature-icon">
                            <rect x="0.5" width="16" height="16" rx="8" fill="currentColor"></rect>
                            <path d="M11.8472 4.70553C12.0558 4.46006 12.424 4.43021 12.6694 4.63886C12.9149 4.84751 12.9448 5.21565 12.7361 5.46112L7.77779 11.2945C7.56586 11.5438 7.19035 11.57 6.94578 11.3526L4.32078 9.01931C4.07999 8.80528 4.0583 8.43657 4.27233 8.19578C4.48637 7.95499 4.85508 7.9333 5.09587 8.14734L7.27511 10.0844L11.8472 4.70553Z" fill="white"></path>
                        </svg>
                        <p>أهم الفعاليات</p>
                    </div>
                    <div class="feature-item">
                        <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="feature-icon">
                            <rect x="0.5" width="16" height="16" rx="8" fill="currentColor"></rect>
                            <path d="M11.8472 4.70553C12.0558 4.46006 12.424 4.43021 12.6694 4.63886C12.9149 4.84751 12.9448 5.21565 12.7361 5.46112L7.77779 11.2945C7.56586 11.5438 7.19035 11.57 6.94578 11.3526L4.32078 9.01931C4.07999 8.80528 4.0583 8.43657 4.27233 8.19578C4.48637 7.95499 4.85508 7.9333 5.09587 8.14734L7.27511 10.0844L11.8472 4.70553Z" fill="white"></path>
                        </svg>
                        <p>أخبار مثيرة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once "footer.php";
?>

<script>
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");

        // إخفاء جميع الصور
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }

        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}    

        // إزالة الفعالية من جميع النقاط
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" actٍive", "");
        }

        // عرض الصورة الحالية وتفعيل النقطة المناسبة
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
                    // تحديث العدد في السلة مباشرة
                    $('.cart-count').text(response.cartCount);

                    // عرض الرسالة داخل الصفحة
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
