-- TechShilpo Database Schema
-- Run this SQL to create the database and tables

CREATE DATABASE IF NOT EXISTS techshilpo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE techshilpodb;

-- Software Products Table
CREATE TABLE IF NOT EXISTS software (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(500),
    demo_url VARCHAR(500),
    buy_url VARCHAR(500),
    features JSON,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contact Messages Table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Demo Images Table (for software demo carousel)
CREATE TABLE IF NOT EXISTS demo_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    software_id INT,
    title VARCHAR(255) NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    link_url VARCHAR(500),
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (software_id) REFERENCES software(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Client Reviews Table
CREATE TABLE IF NOT EXISTS client_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(255) NOT NULL,
    company_name VARCHAR(255),
    client_image VARCHAR(500),
    review_text TEXT NOT NULL,
    rating INT DEFAULT 5,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default software data
INSERT INTO software (name, description, image, demo_url, buy_url, features, sort_order) VALUES
('POS সিস্টেম', 'রেস্টুরেন্ট ও রিটেইল ব্যবসার জন্য সম্পূর্ণ পয়েন্ট অফ সেল সমাধান', 'pos.png', '#demo-pos', '#buy-pos', '["বিলিং", "ইনভেন্টরি", "রিপোর্ট"]', 1),
('ইনভেন্টরি মিনি', 'ছোট ব্যবসার জন্য সহজ ও কার্যকর স্টক ম্যানেজমেন্ট সিস্টেম', 'inventory-management-software.png', '#demo-inventory-mini', '#buy-inventory-mini', '["স্টক", "সেলস"]', 2),
('ইনভেন্টরি বিগ', 'বড় আকারের ব্যবসার জন্য উন্নত ইনভেন্টরি ম্যানেজমেন্ট সফটওয়্যার', 'inventory-software-device.png', '#demo-inventory-big', '#buy-inventory-big', '["মাল্টি-ব্রাঞ্চ", "অটোমেশন"]', 3),
('ই-কমার্স', 'সম্পূর্ণ অনলাইন শপিং সলিউশন পেমেন্ট গেটওয়ে সহ', 'ecommerce.png', '#demo-ecommerce', '#buy-ecommerce', '["স্টোর", "পেমেন্ট"]', 4),
('পোর্টফোলিও', 'আকর্ষণীয় ও প্রফেশনাল পার্সোনাল পোর্টফোলিও সাইট', 'portfolio.png', '#demo-portfolio', '#buy-portfolio', '["রেসপন্সিভ", "এসইও"]', 5);

-- Insert default demo images
INSERT INTO demo_images (software_id, title, image_url, link_url, sort_order) VALUES
(1, 'POS সিস্টেম ড্যাশবোর্ড', 'demo/pos-dashboard.png', '#demo-pos', 1),
(1, 'POS বিলিং স্ক্রিন', 'demo/pos-billing.png', '#demo-pos', 2),
(2, 'ইনভেন্টরি মিনি হোম', 'demo/inventory-mini.png', '#demo-inventory-mini', 3),
(3, 'ইনভেন্টরি বিগ রিপোর্ট', 'demo/inventory-big.png', '#demo-inventory-big', 4),
(4, 'ই-কমার্স স্টোর', 'demo/ecommerce-store.png', '#demo-ecommerce', 5),
(5, 'পোর্টফোলিও টেমপ্লেট', 'demo/portfolio-template.png', '#demo-portfolio', 6);

-- Insert default client reviews
INSERT INTO client_reviews (client_name, company_name, client_image, review_text, rating, sort_order) VALUES
('মোঃ করিম উদ্দিন', 'করিম ট্রেডার্স', 'clients/client1.jpg', 'TechShilpo-র POS সিস্টেম আমাদের ব্যবসায় বিপ্লব এনেছে। এখন সব হিসাব-নিকাশ অনেক সহজ হয়ে গেছে।', 5, 1),
('ফাতেমা বেগম', 'ফ্যাশন হাউস', 'clients/client2.jpg', 'অসাধারণ সার্ভিস এবং সাপোর্ট! ইনভেন্টরি ম্যানেজমেন্ট সফটওয়্যার আমাদের স্টক ট্র্যাকিং অনেক সহজ করে দিয়েছে।', 5, 2),
('আব্দুল হক', 'হক ইলেকট্রনিক্স', 'clients/client3.jpg', 'প্রফেশনাল টিম এবং চমৎকার প্রোডাক্ট। আমাদের ই-কমার্স সাইট তৈরি করে দিয়েছে যা গ্রাহকরা খুবই পছন্দ করছে।', 5, 3),
('রহিমা খাতুন', 'রহিমা বুটিক', 'clients/client4.jpg', 'TechShilpo-র সাথে কাজ করে খুবই ভালো অভিজ্ঞতা হয়েছে। তাদের সফটওয়্যার ব্যবহার করা অনেক সহজ।', 4, 4);
