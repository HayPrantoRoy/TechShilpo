<?php
// Database connection
$host = 'localhost';
$dbname = 'techshilpodb';
$username = 'root';
$password = '';

$software = [];
$demoImages = [];
$reviews = [];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    // Load software
    $stmt = $pdo->query("SELECT * FROM software WHERE is_active = 1 ORDER BY sort_order ASC");
    $software = $stmt->fetchAll();
    foreach ($software as &$item) {
        $item['features'] = json_decode($item['features'] ?? '[]', true);
    }
    
    // Load demo images
    $stmt = $pdo->query("SELECT * FROM demo_images WHERE is_active = 1 ORDER BY sort_order ASC");
    $demoImages = $stmt->fetchAll();
    
    // Load reviews
    $stmt = $pdo->query("SELECT * FROM client_reviews WHERE is_active = 1 ORDER BY sort_order ASC");
    $reviews = $stmt->fetchAll();
    
} catch(PDOException $e) {
    // Use fallback data if database connection fails
}

// Default image path
$defaultImage = 'images/default-avatar.png';
?>
<!DOCTYPE html>
<html lang="bn">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TechShilpo</title>
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <div class="logo-header">
      <img src="logo/techshilpo.png" alt="TechShilpo Logo">
    </div>
    <button class="mobile-menu-toggle" aria-label="Toggle mobile menu">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <nav class="nav-menu">
      <ul>
        <li><a href="#home">হোম</a></li>
        <li><a href="#software">সফটওয়্যার</a></li>
        <li><a href="#demo">ডেমো</a></li>
        <li><a href="#about">আমাদের সম্পর্কে</a></li>
        <li><a href="#contact">যোগাযোগ</a></li>
      </ul>
    </nav>
  </header>

  <section id="home" class="main-content">
    <div class="content-left">
      <h1>TechShilpo - প্রযুক্তির বিশ্বে আপনার নির্ভরযোগ্য সঙ্গী</h1>
      <p>আমরা প্রদান করি উচ্চমানের সফটওয়্যার সমাধান এবং কার্যকরী প্রশিক্ষণ প্রোগ্রাম যা আপনার ক্যারিয়ার এবং ব্যবসাকে এগিয়ে নেবে প্রযুক্তির অগ্রযাত্রায়।</p>
      <div class="btn-group">
        <a href="#software" class="btn-primary">সফটওয়্যার</a>
        <a href="#demo" class="btn-secondary">ডেমো দেখুন</a>
      </div>
    </div>
    <div class="content-right">
      <div class="code-editor-container">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="editor-header">
          <div class="traffic-lights">
            <div class="light red"></div>
            <div class="light yellow"></div>
            <div class="light green"></div>
          </div>
          <div class="editor-title">main.js - TechShilpo</div>
        </div>
        <div class="code-content">
          <div class="code-line">
            <span class="line-number">1</span>
            <span class="keyword">const</span> <span class="variable">techShilpo</span> <span class="operator">=</span>
            <span class="function">require</span><span class="operator">(</span><span class="string">'techshilpo'</span><span class="operator">);</span>
          </div>
          <div class="code-line">
            <span class="line-number">2</span>
            <span class="comment">// আধুনিক সফটওয়্যার সমাধান</span>
          </div>
          <div class="code-line">
            <span class="line-number">3</span>
            <span class="keyword">function</span> <span class="function">createSolution</span><span class="operator">() {</span>
          </div>
          <div class="code-line">
            <span class="line-number">4</span>
            &nbsp;&nbsp;<span class="keyword">return</span> <span class="variable">techShilpo</span><span class="operator">.</span><span class="function">build</span><span class="operator">({</span>
          </div>
          <div class="code-line">
            <span class="line-number">5</span>
            &nbsp;&nbsp;&nbsp;&nbsp;<span class="variable">quality</span><span class="operator">:</span> <span class="string">'premium'</span><span class="operator">,</span>
          </div>
          <div class="code-line">
            <span class="line-number">6</span>
            &nbsp;&nbsp;&nbsp;&nbsp;<span class="variable">training</span><span class="operator">:</span> <span class="keyword">"Javascript,Python,PHP & C#"</span><span class="operator">,</span>
          </div>
          <div class="code-line">
            <span class="line-number">7</span>
            &nbsp;&nbsp;&nbsp;&nbsp;<span class="variable">support</span><span class="operator">:</span> <span class="string">'24/7'</span>
          </div>
          <div class="code-line">
            <span class="line-number">8</span>
            &nbsp;&nbsp;<span class="operator">});</span>
            <span class="cursor"></span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Software Section -->
  <section id="software" class="software-section">
    <div class="software-container">
      <h2 class="section-title">আমাদের সফটওয়্যার সমূহ</h2>
      <p class="section-subtitle">আধুনিক ও কার্যকর সফটওয়্যার সমাধান যা আপনার ব্যবসায়িক চাহিদা পূরণ করবে</p>

      <div class="software-grid">
        <?php if (!empty($software)): ?>
          <?php foreach ($software as $item): ?>
            <div class="software-card">
              <div class="card-image">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" onerror="this.style.display='none'">
              </div>
              <div class="card-content">
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <p><?= htmlspecialchars($item['description']) ?></p>
                <div class="card-features">
                  <?php foreach ($item['features'] ?? [] as $feature): ?>
                    <span class="feature-tag"><?= htmlspecialchars($feature) ?></span>
                  <?php endforeach; ?>
                </div>
                <div class="software-btn-group">
                  <a href="<?= htmlspecialchars($item['buy_url'] ?? '#') ?>" class="btn-software btn-buy">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <span>কিনুন</span>
                  </a>
                  <a href="<?= htmlspecialchars($item['demo_url'] ?? '#') ?>" class="btn-software btn-demo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <polygon points="5 3 19 12 5 21 5 3"/>
                    </svg>
                    <span>ডেমো</span>
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <!-- Fallback static content -->
          <div class="software-card">
            <div class="card-image">
              <img src="pos.png" alt="POS System" onerror="this.style.display='none'">
            </div>
            <div class="card-content">
              <h3>POS সিস্টেম</h3>
              <p>রেস্টুরেন্ট ও রিটেইল ব্যবসার জন্য সম্পূর্ণ পয়েন্ট অফ সেল সমাধান</p>
              <div class="card-features">
                <span class="feature-tag">বিলিং</span>
                <span class="feature-tag">ইনভেন্টরি</span>
                <span class="feature-tag">রিপোর্ট</span>
              </div>
              <div class="software-btn-group">
                <a href="#" class="btn-software btn-buy">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                  </svg>
                  <span>কিনুন</span>
                </a>
                <a href="#" class="btn-software btn-demo">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="5 3 19 12 5 21 5 3"/>
                  </svg>
                  <span>ডেমো</span>
                </a>
              </div>
            </div>
          </div>
          <div class="software-card">
            <div class="card-image">
              <img src="inventory-management-software.png" alt="Inventory" onerror="this.style.display='none'">
            </div>
            <div class="card-content">
              <h3>ইনভেন্টরি সিস্টেম</h3>
              <p>ছোট ব্যবসার জন্য সহজ ও কার্যকর স্টক ম্যানেজমেন্ট সিস্টেম</p>
              <div class="card-features">
                <span class="feature-tag">স্টক</span>
                <span class="feature-tag">সেলস</span>
              </div>
              <div class="software-btn-group">
                <a href="#" class="btn-software btn-buy">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                  </svg>
                  <span>কিনুন</span>
                </a>
                <a href="#" class="btn-software btn-demo">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="5 3 19 12 5 21 5 3"/>
                  </svg>
                  <span>ডেমো</span>
                </a>
              </div>
            </div>
          </div>
          <div class="software-card">
            <div class="card-image">
              <img src="ecommerce.png" alt="E-Commerce" onerror="this.style.display='none'">
            </div>
            <div class="card-content">
              <h3>ই-কমার্স</h3>
              <p>সম্পূর্ণ অনলাইন শপিং সলিউশন পেমেন্ট গেটওয়ে সহ</p>
              <div class="card-features">
                <span class="feature-tag">স্টোর</span>
                <span class="feature-tag">পেমেন্ট</span>
              </div>
              <div class="software-btn-group">
                <a href="#" class="btn-software btn-buy">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                  </svg>
                  <span>কিনুন</span>
                </a>
                <a href="#" class="btn-software btn-demo">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="5 3 19 12 5 21 5 3"/>
                  </svg>
                  <span>ডেমো</span>
                </a>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Demo Showcase Section -->
  <section id="demo" class="demo-section">
    <div class="demo-container">
      <h2 class="section-title">সফটওয়্যার ডেমো</h2>
      <p class="section-subtitle">আমাদের সফটওয়্যার সমূহের লাইভ প্রিভিউ দেখুন</p>

      <div class="demo-showcase">
        <div class="demo-main-slider">
          <div class="demo-slides-wrapper" id="demo-slides">
            <?php if (!empty($demoImages)): ?>
              <?php foreach ($demoImages as $index => $demo): ?>
                <div class="demo-slide <?= $index === 0 ? 'active' : '' ?>">
                  <a href="<?= htmlspecialchars($demo['link_url'] ?? '#') ?>" class="demo-slide-link">
                    <div class="demo-image-wrapper">
                      <img src="<?= htmlspecialchars($demo['image_url']) ?>" alt="<?= htmlspecialchars($demo['title']) ?>" onerror="this.parentElement.innerHTML='<div class=\'demo-placeholder\'><svg viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div>'">
                    </div>
                    <div class="demo-slide-overlay">
                      <h3><?= htmlspecialchars($demo['title']) ?></h3>
                      <span class="demo-view-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                        </svg>
                        বিস্তারিত দেখুন
                      </span>
                    </div>
                  </a>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="demo-slide active">
                <a href="#" class="demo-slide-link">
                  <div class="demo-image-wrapper">
                    <img src="pos.png" alt="POS Demo" onerror="this.parentElement.innerHTML='<div class=\'demo-placeholder\'><svg viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div>'">
                  </div>
                  <div class="demo-slide-overlay">
                    <h3>POS সিস্টেম ড্যাশবোর্ড</h3>
                    <span class="demo-view-btn">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                      </svg>
                      বিস্তারিত দেখুন
                    </span>
                  </div>
                </a>
              </div>
              <div class="demo-slide">
                <a href="#" class="demo-slide-link">
                  <div class="demo-image-wrapper">
                    <img src="inventory-management-software.png" alt="Inventory Demo" onerror="this.parentElement.innerHTML='<div class=\'demo-placeholder\'><svg viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div>'">
                  </div>
                  <div class="demo-slide-overlay">
                    <h3>ইনভেন্টরি মিনি</h3>
                    <span class="demo-view-btn">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                      </svg>
                      বিস্তারিত দেখুন
                    </span>
                  </div>
                </a>
              </div>
              <div class="demo-slide">
                <a href="#" class="demo-slide-link">
                  <div class="demo-image-wrapper">
                    <img src="ecommerce.png" alt="E-Commerce Demo" onerror="this.parentElement.innerHTML='<div class=\'demo-placeholder\'><svg viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\'><rect x=\'3\' y=\'3\' width=\'18\' height=\'18\' rx=\'2\'/><circle cx=\'8.5\' cy=\'8.5\' r=\'1.5\'/><path d=\'M21 15l-5-5L5 21\'/></svg></div>'">
                  </div>
                  <div class="demo-slide-overlay">
                    <h3>ই-কমার্স স্টোর</h3>
                    <span class="demo-view-btn">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                      </svg>
                      বিস্তারিত দেখুন
                    </span>
                  </div>
                </a>
              </div>
            <?php endif; ?>
          </div>
          
          <button class="demo-nav-btn demo-prev" id="demo-prev">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="15 18 9 12 15 6"/>
            </svg>
          </button>
          <button class="demo-nav-btn demo-next" id="demo-next">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="9 18 15 12 9 6"/>
            </svg>
          </button>
        </div>

        <div class="demo-thumbnails">
          <?php $slideCount = !empty($demoImages) ? count($demoImages) : 3; ?>
          <?php for ($i = 0; $i < $slideCount; $i++): ?>
            <button class="demo-thumb <?= $i === 0 ? 'active' : '' ?>" data-index="<?= $i ?>">
              <span class="thumb-progress"></span>
            </button>
          <?php endfor; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Client Reviews Section -->
  <section id="reviews" class="reviews-section">
    <div class="reviews-container">
      <h2 class="section-title">গ্রাহকদের মতামত</h2>
      <p class="section-subtitle">আমাদের সম্মানিত গ্রাহকরা কী বলছেন</p>

      <div class="reviews-grid">
        <?php if (!empty($reviews)): ?>
          <?php foreach ($reviews as $review): ?>
            <div class="review-card">
              <div class="review-header">
                <?php if (!empty($review['client_image'])): ?>
                  <img src="<?= htmlspecialchars($review['client_image']) ?>" alt="<?= htmlspecialchars($review['client_name']) ?>" class="review-avatar" onerror="this.outerHTML='<div class=\'review-avatar-placeholder\'><?= mb_substr($review['client_name'], 0, 1) ?></div>'">
                <?php else: ?>
                  <div class="review-avatar-placeholder"><?= mb_substr($review['client_name'], 0, 1) ?></div>
                <?php endif; ?>
                <div class="review-info">
                  <h4><?= htmlspecialchars($review['client_name']) ?></h4>
                  <span class="review-company"><?= htmlspecialchars($review['company_name'] ?? '') ?></span>
                </div>
              </div>
              <div class="review-rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <span class="review-star <?= $i > ($review['rating'] ?? 5) ? 'empty' : '' ?>">★</span>
                <?php endfor; ?>
              </div>
              <p class="review-text"><?= htmlspecialchars($review['review_text']) ?></p>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <!-- Fallback reviews -->
          <div class="review-card">
            <div class="review-header">
              <div class="review-avatar-placeholder">ম</div>
              <div class="review-info">
                <h4>মোঃ করিম উদ্দিন</h4>
                <span class="review-company">করিম ট্রেডার্স</span>
              </div>
            </div>
            <div class="review-rating">
              <span class="review-star">★</span>
              <span class="review-star">★</span>
              <span class="review-star">★</span>
              <span class="review-star">★</span>
              <span class="review-star">★</span>
            </div>
            <p class="review-text">TechShilpo-র POS সিস্টেম আমাদের ব্যবসায় বিপ্লব এনেছে। এখন সব হিসাব-নিকাশ অনেক সহজ হয়ে গেছে।</p>
          </div>
          <div class="review-card">
            <div class="review-header">
              <div class="review-avatar-placeholder">ফ</div>
              <div class="review-info">
                <h4>ফাতেমা বেগম</h4>
                <span class="review-company">ফ্যাশন হাউস</span>
              </div>
            </div>
            <div class="review-rating">
              <span class="review-star">★</span>
              <span class="review-star">★</span>
              <span class="review-star">★</span>
              <span class="review-star">★</span>
              <span class="review-star">★</span>
            </div>
            <p class="review-text">অসাধারণ সার্ভিস এবং সাপোর্ট! ইনভেন্টরি ম্যানেজমেন্ট সফটওয়্যার আমাদের স্টক ট্র্যাকিং অনেক সহজ করে দিয়েছে।</p>
          </div>
          <div class="review-card">
            <div class="review-header">
              <div class="review-avatar-placeholder">আ</div>
              <div class="review-info">
                <h4>আব্দুল হক</h4>
                <span class="review-company">হক ইলেকট্রনিক্স</span>
              </div>
            </div>
            <div class="review-rating">
              <span class="review-star">★</span>
              <span class="review-star">★</span>
              <span class="review-star">★</span>
              <span class="review-star">★</span>
              <span class="review-star">★</span>
            </div>
            <p class="review-text">প্রফেশনাল টিম এবং চমৎকার প্রোডাক্ট। আমাদের ই-কমার্স সাইট তৈরি করে দিয়েছে যা গ্রাহকরা খুবই পছন্দ করছে।</p>
          </div>
          <div class="review-card">
            <div class="review-header">
              <div class="review-avatar-placeholder">র</div>
              <div class="review-info">
                <h4>রহিমা খাতুন</h4>
                <span class="review-company">রহিমা বুটিক</span>
              </div>
            </div>
            <div class="review-rating">
              <span class="review-star">★</span>
              <span class="review-star">★</span>
              <span class="review-star">★</span>
              <span class="review-star">★</span>
              <span class="review-star empty">★</span>
            </div>
            <p class="review-text">TechShilpo-র সাথে কাজ করে খুবই ভালো অভিজ্ঞতা হয়েছে। তাদের সফটওয়্যার ব্যবহার করা অনেক সহজ।</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="about-section">
    <div class="about-container">
      <h2 class="section-title">আমাদের টিম</h2>
      <p class="section-subtitle">দক্ষ ও অভিজ্ঞ পেশাদারদের নিয়ে গঠিত আমাদের টিম</p>

      <div class="team-grid-modern">
        <!-- Team Member 1 -->
        <div class="team-card-v2">
          <div class="card-glow"></div>
          <div class="card-content-v2">
            <div class="member-photo-wrapper">
              <div class="photo-ring"></div>
              <div class="photo-ring ring-2"></div>
              <img src="https://birganjcitycare.com/img/sohag.jpg" alt="সোহাগ আলী" class="member-photo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
              <div class="photo-fallback" style="display:none;">স</div>
            </div>
            <div class="member-details">
              <span class="member-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                  <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                ম্যানেজিং ডিরেক্টর
              </span>
              <h3 class="member-name">সোহাগ আলী</h3>
              <div class="member-social">
                <a href="tel:+8801745830123" class="social-btn phone">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                  </svg>
                </a>
                <a href="mailto:Sohagali.aiu@gmail.com" class="social-btn email">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Team Member 2 -->
        <div class="team-card-v2">
          <div class="card-glow"></div>
          <div class="card-content-v2">
            <div class="member-photo-wrapper">
              <div class="photo-ring"></div>
              <div class="photo-ring ring-2"></div>
              <img src="https://pranto.info/images/pranto_img.jpeg" alt="প্রান্ত রায়" class="member-photo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
              <div class="photo-fallback" style="display:none;">প</div>
            </div>
            <div class="member-details">
              <span class="member-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                  <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
                </svg>
                চিফ সফটওয়্যার ডেভেলপার
              </span>
              <h3 class="member-name">প্রান্ত রায়</h3>
              <div class="member-social">
                <a href="tel:+8801842494422" class="social-btn phone">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                  </svg>
                </a>
                <a href="mailto:prantoroy23006@gmail.com" class="social-btn email">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Team Member 3 -->
        <div class="team-card-v2">
          <div class="card-glow"></div>
          <div class="card-content-v2">
            <div class="member-photo-wrapper">
              <div class="photo-ring"></div>
              <div class="photo-ring ring-2"></div>
              <div class="photo-fallback">অ</div>
            </div>
            <div class="member-details">
              <span class="member-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                  <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
                </svg>
                ওয়েব ডেভেলপার
              </span>
              <h3 class="member-name">অবিনাশ সরকার</h3>
              <div class="member-social">
                <a href="#" class="social-btn phone">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                  </svg>
                </a>
                <a href="#" class="social-btn email">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Team Member 4 -->
        <div class="team-card-v2">
          <div class="card-glow"></div>
          <div class="card-content-v2">
            <div class="member-photo-wrapper">
              <div class="photo-ring"></div>
              <div class="photo-ring ring-2"></div>
              <div class="photo-fallback">মি</div>
            </div>
            <div class="member-details">
              <span class="member-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                  <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
                ওয়েব ডেভেলপার
              </span>
              <h3 class="member-name">মোঃ মিজানুর রহমান</h3>
              <div class="member-social">
                <a href="tel:+8801740246091" class="social-btn phone">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                  </svg>
                </a>
                <a href="mailto:geniuscomputer2013@gmail.com" class="social-btn email">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="contact-section">
    <div class="contact-container">
      <h2 class="section-title">যোগাযোগ করুন</h2>
      <p class="section-subtitle">আমাদের সাথে যোগাযোগ করতে নিচের ফর্ম পূরণ করুন</p>

      <div class="contact-wrapper">
        <div class="contact-form-container">
          <form class="contact-form" id="contact-form" method="POST" action="api/contact.php">
            <div class="form-group">
              <label for="name">আপনার নাম</label>
              <input type="text" id="name" name="name" placeholder="আপনার সম্পূর্ণ নাম" required>
            </div>
            <div class="form-group">
              <label for="email">ইমেইল</label>
              <input type="email" id="email" name="email" placeholder="your@email.com" required>
            </div>
            <div class="form-group">
              <label for="phone">ফোন নম্বর</label>
              <input type="tel" id="phone" name="phone" placeholder="০১৭XXXXXXXX" required>
            </div>
            <div class="form-group">
              <label for="message">বার্তা</label>
              <textarea id="message" name="message" rows="5" placeholder="আপনার বার্তা..." required></textarea>
            </div>
            <button type="submit" class="btn-submit">
              <span class="btn-text">পাঠান</span>
              <span class="btn-shine"></span>
            </button>
          </form>
        </div>

        <div class="contact-info">
          <div class="info-card">
            <h4>ঠিকানা</h4>
            <p>ঢাকা, বাংলাদেশ<br>মিরপুর-১০</p>
          </div>
          <div class="info-card">
            <h4>ফোন</h4>
            <p>+৮৮০ ১৭XX XXXXXX</p>
          </div>
          <div class="info-card">
            <h4>ইমেইল</h4>
            <p>info@techshilpo.com</p>
          </div>
          <div class="info-card">
            <h4>কর্মসময়</h4>
            <p>সোমবার - শুক্রবার<br>৯:০০ - ৬:০০</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-grid">
        <div class="footer-column">
          <div class="footer-logo">
            <img src="logo/techshilpo.png" alt="TechShilpo" onerror="this.style.display='none'">
          </div>
          <p class="footer-desc">প্রযুক্তির বিশ্বে আপনার নির্ভরযোগ্য সঙ্গী</p>
        </div>
        <div class="footer-column">
          <h4>দ্রুত লিংক</h4>
          <ul>
            <li><a href="#home">হোম</a></li>
            <li><a href="#software">সফটওয়্যার</a></li>
            <li><a href="#demo">ডেমো</a></li>
            <li><a href="#about">আমাদের সম্পর্কে</a></li>
          </ul>
        </div>
        <div class="footer-column">
          <h4>সেবা সমূহ</h4>
          <ul>
            <li><a href="#">সফটওয়্যার ডেভেলপমেন্ট</a></li>
            <li><a href="#">ওয়েব ডিজাইন</a></li>
            <li><a href="#">প্রশিক্ষণ</a></li>
            <li><a href="#">সাপোর্ট</a></li>
          </ul>
        </div>
        <div class="footer-column">
          <h4>যোগাযোগ</h4>
          <ul>
            <li class="footer-contact-item">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="rgba(139, 92, 246, 0.9)" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
              <span>ঢাকা, বাংলাদেশ</span>
            </li>
            <li class="footer-contact-item">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="rgba(139, 92, 246, 0.9)" stroke-width="2">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
              </svg>
              <span>+৮৮০ ১৭XX XXXXXX</span>
            </li>
            <li class="footer-contact-item">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="rgba(139, 92, 246, 0.9)" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
              </svg>
              <span>info@techshilpo.com</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; ২০২৪ TechShilpo. সর্বস্বত্ব সংরক্ষিত।</p>
      </div>
    </div>
  </footer>

  <script>
    // Mobile menu toggle functionality
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const body = document.body;

    mobileMenuToggle.addEventListener('click', () => {
      mobileMenuToggle.classList.toggle('active');
      navMenu.classList.toggle('active');
      body.classList.toggle('menu-open');
    });

    // Close menu when clicking on nav links
    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        mobileMenuToggle.classList.remove('active');
        navMenu.classList.remove('active');
        body.classList.remove('menu-open');
      });
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!mobileMenuToggle.contains(e.target) && !navMenu.contains(e.target)) {
        mobileMenuToggle.classList.remove('active');
        navMenu.classList.remove('active');
        body.classList.remove('menu-open');
      }
    });

    // Demo Carousel
    let currentSlide = 0;
    const slides = document.querySelectorAll('.demo-slide');
    const thumbs = document.querySelectorAll('.demo-thumb');
    const totalSlides = slides.length;
    let autoSlideInterval;

    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === index);
      });
      thumbs.forEach((thumb, i) => {
        thumb.classList.toggle('active', i === index);
      });
      currentSlide = index;
    }

    function nextSlide() {
      showSlide((currentSlide + 1) % totalSlides);
    }

    function prevSlide() {
      showSlide((currentSlide - 1 + totalSlides) % totalSlides);
    }

    function startAutoSlide() {
      autoSlideInterval = setInterval(nextSlide, 5000);
    }

    function resetAutoSlide() {
      clearInterval(autoSlideInterval);
      startAutoSlide();
    }

    document.getElementById('demo-next')?.addEventListener('click', () => { nextSlide(); resetAutoSlide(); });
    document.getElementById('demo-prev')?.addEventListener('click', () => { prevSlide(); resetAutoSlide(); });

    thumbs.forEach((thumb, index) => {
      thumb.addEventListener('click', () => { showSlide(index); resetAutoSlide(); });
    });

    startAutoSlide();

    // Contact form submission
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
      contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(contactForm);
        const data = Object.fromEntries(formData);
        
        const submitBtn = contactForm.querySelector('.btn-submit');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="btn-text">পাঠানো হচ্ছে...</span>';
        submitBtn.disabled = true;

        try {
          const response = await fetch('api/contact.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
          });

          const result = await response.json();
          
          if (response.ok && result.success) {
            alert('বার্তা সফলভাবে পাঠানো হয়েছে!');
            contactForm.reset();
          } else {
            throw new Error(result.error || 'Error');
          }
        } catch (error) {
          alert('বার্তা পাঠাতে সমস্যা হয়েছে। অনুগ্রহ করে পরে আবার চেষ্টা করুন।');
        } finally {
          submitBtn.innerHTML = originalText;
          submitBtn.disabled = false;
        }
      });
    }
  </script>
</body>
</html>
