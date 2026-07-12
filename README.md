nohup php artisan queue:work > /dev/null 2>&1 &

server {
    listen 80;
    server_name api.mycv.local;
    
    # Trỏ thẳng vào thư mục public của Laravel API
    root /media/tutn/Data/www/mycv-api/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html index.htm;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        # THAY ĐỔI phiên bản PHP ở đây nếu cần
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
