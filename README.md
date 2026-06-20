nohup php artisan queue:work > /dev/null 2>&1 &

// Lưu ý: trước đây code dùng config(env('API_URL'), env('API_URL')), đây là cách dùng
// SAI hàm config() — tham số đầu của config() phải là TÊN KHOÁ cấu hình (vd:
// 'services.api.url'), không phải giá trị URL. Vì key đó không tồn tại trong config nên
// config() luôn rơi vào giá trị mặc định (chính là env('API_URL')) — code "chạy được"
// chỉ là tình cờ. Ngoài ra không nên gọi env() trực tiếp ngoài file config/\*.php vì sẽ
// trả về null khi chạy `php artisan config:cache`.
// => Khuyến nghị: thêm 'url' vào config/services.php, vd:
// 'api' => ['url' => env('API_URL')],
// rồi dùng: config('services.api.url')
